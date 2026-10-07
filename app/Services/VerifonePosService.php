<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifonePosService
{
    /**
     * Get Base URL according to environment setting
     */
    protected function getBaseUrl(Restaurant $restaurant): string
    {
        $env = $restaurant->verifone_environment ?? 'sandbox';
        if ($env === 'production') {
            return config('services.verifone.production_url', 'https://poscloud.verifone.cloud/oidc/poscloud/nexo');
        }
        return config('services.verifone.sandbox_url', 'https://cstpos.test-gsc.vfims.com/oidc/poscloud/nexo');
    }

    /**
     * Generate Basic Auth Token from UID and API Key
     */
    public function getAuthToken(Restaurant $restaurant): string
    {
        $uid = trim($restaurant->verifone_uid ?? '');
        $apiKey = trim($restaurant->verifone_api_key ?? '');
        
        if (empty($uid) || empty($apiKey)) {
            throw new \Exception('Verifone POS credentials (UID or API Key) missing for restaurant ID #' . $restaurant->id);
        }

        return 'Basic ' . base64_encode($uid . ':' . $apiKey);
    }

    /**
     * Get Request Headers (includes Authorization and x-site-entity-id)
     */
    public function getRequestHeaders(Restaurant $restaurant): array
    {
        $headers = [
            'Authorization' => $this->getAuthToken($restaurant),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        if (!empty($restaurant->verifone_entity_uid)) {
            $headers['x-site-entity-id'] = $restaurant->verifone_entity_uid;
        }

        return $headers;
    }

    /**
     * Check connection status of terminal and auto-fetch POIID and entityUID
     */
    public function checkStatus(Restaurant $restaurant, ?string $serialNumber = null): array
    {
        try {
            $sn = trim($serialNumber ?: ($restaurant->verifone_serial_number ?: ($restaurant->verifone_poiid ?: '')));
            $baseUrl = $this->getBaseUrl($restaurant);
            $url = !empty($sn) ? $baseUrl . '/status/' . $sn : $baseUrl . '/status';
            $token = $this->getAuthToken($restaurant);

            $headers = [
                'Authorization' => $token,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ];
            if (!empty($restaurant->verifone_entity_uid)) {
                $headers['x-site-entity-id'] = $restaurant->verifone_entity_uid;
            }

            $response = Http::withHeaders($headers)->timeout(15)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $poiStatus = $data['POIStatus'] ?? [];
                $isConnected = false;
                $poiIdFetched = null;
                $entityUidFetched = null;
                
                if (is_array($poiStatus) && count($poiStatus) > 0) {
                    $firstPoi = $poiStatus[0];
                    $poiIdFetched = $firstPoi['POIID'] ?? null;
                    $entityUidFetched = $firstPoi['entityUID'] ?? null;
                    $fetchedSn = $firstPoi['serialNumber'] ?? null;

                    if (isset($firstPoi['POIState']) && strtoupper($firstPoi['POIState']) === 'CONNECTED') {
                        $isConnected = true;
                    }

                    // Auto-update restaurant DB record with fetched POIID, EntityUID, and SerialNumber
                    $needsSave = false;
                    if ($poiIdFetched && $restaurant->verifone_poiid !== $poiIdFetched) {
                        $restaurant->verifone_poiid = $poiIdFetched;
                        $needsSave = true;
                    }
                    if ($entityUidFetched && $restaurant->verifone_entity_uid !== $entityUidFetched) {
                        $restaurant->verifone_entity_uid = $entityUidFetched;
                        $needsSave = true;
                    }
                    if ($fetchedSn && $restaurant->verifone_serial_number !== $fetchedSn) {
                        $restaurant->verifone_serial_number = $fetchedSn;
                        $needsSave = true;
                    }
                    if ($needsSave) {
                        $restaurant->save();
                    }
                }

                return [
                    'success'      => true,
                    'connected'    => $isConnected,
                    'poi_id'       => $poiIdFetched ?: $restaurant->verifone_poiid,
                    'entity_uid'   => $entityUidFetched ?: $restaurant->verifone_entity_uid,
                    'data'         => $data,
                ];
            }

            return [
                'success'   => false,
                'connected' => false,
                'error'     => 'HTTP ' . $response->status() . ': ' . $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('Verifone POS Status Check Failed', [
                'restaurant_id' => $restaurant->id,
                'error'         => $e->getMessage()
            ]);

            return [
                'success'   => false,
                'connected' => false,
                'error'     => $e->getMessage(),
            ];
        }
    }

    /**
     * Process Sale Payment on Verifone Terminal
     */
    public function processSalePayment(Order $order, float $amount, ?string $operatorId = null): array
    {
        $restaurant = $order->restaurant;
        if (!$restaurant || !$restaurant->verifone_enabled) {
            return [
                'success' => false,
                'error'   => 'Verifone POS integration is not enabled for this restaurant.',
            ];
        }

        $serviceId = 'SRV-' . $order->id . '-' . time();
        $saleId = $restaurant->verifone_sale_id ?: 'RetailPOS';
        $poiId = $restaurant->verifone_poiid ?: 'Point of Interaction';
        $operator = $operatorId ?: (string) (auth()->id() ?? '1');
        $currency = config('app.currency', 'GBP');

        $payload = [
            'MessageHeader' => [
                'MessageClass'    => 'SERVICE',
                'MessageCategory' => 'PAYMENT',
                'MessageType'     => 'REQUEST',
                'ServiceID'       => $serviceId,
                'SaleID'          => $saleId,
                'POIID'           => $poiId,
            ],
            'PaymentRequest' => [
                'SaleData' => [
                    'OperatorID'        => $operator,
                    'SaleTransactionID' => [
                        'TransactionID' => (string) $order->id,
                        'TimeStamp'     => now()->toIso8601String(),
                    ],
                    'CustomerOrderReq'  => ['string'],
                ],
                'PaymentTransaction' => [
                    'AmountsReq' => [
                        'Currency'        => $currency,
                        'RequestedAmount' => number_format($amount, 2, '.', ''),
                    ],
                ],
                'PaymentData' => [
                    'PaymentType'      => 'NORMAL',
                    'SplitPaymentFlag' => false,
                ],
            ],
        ];

        try {
            $token = $this->getAuthToken($restaurant);
            $url = $this->getBaseUrl($restaurant) . '/payment';

            Log::info('Verifone POS Sale Request Initiated', [
                'order_id'   => $order->id,
                'service_id' => $serviceId,
                'amount'     => $amount,
            ]);

            $headers = $this->getRequestHeaders($restaurant);
            $response = Http::withHeaders($headers)->timeout(120)->post($url, $payload); // 120s timeout to allow customer to enter PIN

            if ($response->successful()) {
                $resData = $response->json();
                $paymentResponse = $resData['PaymentResponse'] ?? [];
                $responseResult = $paymentResponse['Response']['Result'] ?? null;

                if (strtoupper($responseResult) === 'SUCCESS') {
                    $poiData = $paymentResponse['POIData'] ?? [];
                    $poiTxId = $poiData['POITransactionID']['TransactionID'] ?? null;
                    $poiTimeStamp = $poiData['POITransactionID']['TimeStamp'] ?? null;
                    
                    $paymentResult = $paymentResponse['PaymentResult'] ?? [];
                    $maskedPan = $paymentResult['PaymentInstrumentData']['CardData']['MaskedPan'] 
                        ?? $paymentResult['PaymentInstrumentData']['MaskedPan'] 
                        ?? null;
                    $cardBrand = $paymentResult['PaymentInstrumentData']['CardData']['PaymentBrand'] 
                        ?? $paymentResult['PaymentBrand'] 
                        ?? null;
                    $authCode = $paymentResult['PaymentResponse']['AuthCode'] 
                        ?? $paymentResult['AuthCode'] 
                        ?? null;

                    Log::info('Verifone POS Sale Success', [
                        'order_id'   => $order->id,
                        'poi_tx_id'  => $poiTxId,
                        'masked_pan' => $maskedPan,
                    ]);

                    return [
                        'success'            => true,
                        'service_id'         => $serviceId,
                        'poi_transaction_id' => $poiTxId,
                        'poi_timestamp'      => $poiTimeStamp,
                        'masked_pan'         => $maskedPan,
                        'card_brand'         => $cardBrand,
                        'auth_code'          => $authCode,
                        'raw_response'       => $resData,
                    ];
                }

                $errorCondition = $paymentResponse['Response']['ErrorCondition'] ?? 'Unknown Error';
                $additionalResponse = $paymentResponse['Response']['AdditionalResponse'] ?? 'Payment was not approved.';

                Log::warning('Verifone POS Sale Declined', [
                    'order_id' => $order->id,
                    'error'    => $errorCondition,
                    'details'  => $additionalResponse,
                ]);

                return [
                    'success'    => false,
                    'service_id' => $serviceId,
                    'error'      => $additionalResponse . ' (' . $errorCondition . ')',
                    'raw_response' => $resData,
                ];
            }

            return [
                'success'    => false,
                'service_id' => $serviceId,
                'error'      => 'HTTP Error ' . $response->status() . ': ' . $response->body(),
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Verifone POS Timeout / Connection Exception', [
                'order_id'   => $order->id,
                'service_id' => $serviceId,
                'error'      => $e->getMessage()
            ]);

            // Attempt transaction status query on timeout to avoid double charging
            $statusCheck = $this->queryTransactionStatus($restaurant, $serviceId, (string) $order->id);
            if ($statusCheck['success'] && $statusCheck['is_paid']) {
                return $statusCheck;
            }

            return [
                'success'    => false,
                'service_id' => $serviceId,
                'error'      => 'Terminal connection timed out. Please check terminal status.',
            ];
        } catch (\Throwable $e) {
            Log::error('Verifone POS Sale Exception', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Abort ongoing terminal transaction
     */
    public function abortTransaction(Restaurant $restaurant, string $serviceId): array
    {
        $payload = [
            'MessageHeader' => [
                'MessageClass'    => 'SERVICE',
                'MessageCategory' => 'ABORT',
                'MessageType'     => 'REQUEST',
                'ServiceID'       => 'ABT-' . time(),
                'SaleID'          => $restaurant->verifone_sale_id ?: 'RetailPOS',
                'POIID'           => $restaurant->verifone_poiid ?: 'Point of Interaction',
            ],
            'AbortRequest' => [
                'MessageReference' => [
                    'MessageCategory' => 'PAYMENT',
                    'ServiceID'       => $serviceId,
                    'SaleID'          => $restaurant->verifone_sale_id ?: 'RetailPOS',
                    'POIID'           => $restaurant->verifone_poiid ?: 'Point of Interaction',
                ],
                'AbortReason' => 'CashierAborted',
            ],
        ];

        try {
            $headers = $this->getRequestHeaders($restaurant);
            $url = $this->getBaseUrl($restaurant) . '/abort';

            $response = Http::withHeaders($headers)->timeout(10)->post($url, $payload);

            return [
                'success' => $response->successful(),
                'data'    => $response->json(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Query status of a transaction (Timeout Recovery)
     */
    public function queryTransactionStatus(Restaurant $restaurant, string $serviceId, string $orderId): array
    {
        $payload = [
            'MessageHeader' => [
                'MessageClass'    => 'SERVICE',
                'MessageCategory' => 'TRANSACTIONSTATUS',
                'MessageType'     => 'REQUEST',
                'ServiceID'       => 'STAT-' . time(),
                'SaleID'          => $restaurant->verifone_sale_id ?: 'RetailPOS',
                'POIID'           => $restaurant->verifone_poiid ?: 'Point of Interaction',
            ],
            'TransactionStatusRequest' => [
                'MessageReference' => [
                    'messageCategory' => 'PAYMENT',
                    'serviceID'       => $serviceId,
                    'saleID'          => $restaurant->verifone_sale_id ?: 'RetailPOS',
                    'poiid'           => $restaurant->verifone_poiid ?: 'Point of Interaction',
                ],
                'ReceiptReprintFlag' => false,
            ],
        ];

        try {
            $headers = $this->getRequestHeaders($restaurant);
            $url = $this->getBaseUrl($restaurant) . '/transactionstatus';

            $response = Http::withHeaders($headers)->timeout(15)->post($url, $payload);

            if ($response->successful()) {
                $resData = $response->json();
                $statusResp = $resData['TransactionStatusResponse'] ?? [];
                $result = $statusResp['Response']['Result'] ?? null;
                
                if (strtoupper($result) === 'SUCCESS') {
                    return [
                        'success' => true,
                        'is_paid' => true,
                        'data'    => $resData,
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::error('Verifone Transaction Status Query Failed', ['order_id' => $orderId, 'error' => $e->getMessage()]);
        }

        return [
            'success' => false,
            'is_paid' => false,
        ];
    }

    /**
     * Print Receipt on Verifone Terminal Printer
     */
    public function printReceipt(Order $order, string $documentQualifier = 'CUSTOMERRECEIPT'): array
    {
        $restaurant = $order->restaurant;
        if (!$restaurant || !$restaurant->verifone_enabled) {
            return [
                'success' => false,
                'error'   => 'Verifone POS disabled for this restaurant.',
            ];
        }

        $receiptText = $this->generateReceiptText($order);
        $serviceId = 'PRT-' . $order->id . '-' . time();
        $saleId = $restaurant->verifone_sale_id ?: 'RetailPOS';
        $poiId = $restaurant->verifone_poiid ?: 'Point of Interaction';

        $payload = [
            'MessageHeader' => [
                'MessageClass'    => 'DEVICE',
                'MessageCategory' => 'PRINT',
                'MessageType'     => 'REQUEST',
                'ServiceID'       => $serviceId,
                'DeviceID'        => '1375',
                'SaleID'          => $saleId,
                'POIID'           => $poiId,
            ],
            'PrintRequest' => [
                'PrintOutput' => [
                    'DocumentQualifier' => $documentQualifier,
                    'ResponseMode'      => 'NotRequired',
                    'OutputContent'     => [
                        'OutputFormat' => 'TEXT',
                        'OutputText'   => [
                            [
                                'Text' => $receiptText,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $headers = $this->getRequestHeaders($restaurant);
            $url = $this->getBaseUrl($restaurant) . '/print';

            Log::info('Verifone Nexo Print Request Sent', ['order_id' => $order->id]);

            $response = Http::withHeaders($headers)->timeout(20)->post($url, $payload);

            return [
                'success' => $response->successful(),
                'raw'     => $response->json(),
            ];
        } catch (\Throwable $e) {
            Log::error('Verifone Nexo Print Request Exception', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Process Refund via Verifone POS Nexo API
     */
    public function processRefund(Order $order, float $amount, string $reason = ''): array
    {
        $restaurant = $order->restaurant;
        if (!$restaurant || !$restaurant->verifone_enabled) {
            return [
                'success' => false,
                'error'   => 'Verifone POS integration not enabled.',
            ];
        }

        $payment = $order->payment;
        $serviceId = 'RFD-' . $order->id . '-' . time();
        $saleId = $restaurant->verifone_sale_id ?: 'RetailPOS';
        $poiId = $restaurant->verifone_poiid ?: 'Point of Interaction';
        $currency = config('app.currency', 'GBP');

        $payload = [
            'MessageHeader' => [
                'MessageClass'    => 'SERVICE',
                'MessageCategory' => 'PAYMENT',
                'MessageType'     => 'REQUEST',
                'ServiceID'       => $serviceId,
                'SaleID'          => $saleId,
                'POIID'           => $poiId,
            ],
            'PaymentRequest' => [
                'SaleData' => [
                    'OperatorID'        => (string) (auth()->id() ?? '440010051'),
                    'SaleTransactionID' => [
                        'TransactionID' => (string) $order->id,
                        'TimeStamp'     => now()->toIso8601String(),
                    ],
                    'CustomerOrderReq'   => ['string'],
                    'SaleToAcquirerData' => 'tender=MOTO',
                ],
                'PaymentTransaction' => [
                    'AmountsReq' => [
                        'Currency'        => $currency,
                        'RequestedAmount' => number_format($amount, 2, '.', ''),
                    ],
                ],
                'PaymentData' => [
                    'PaymentType'      => 'REFUND',
                    'SplitPaymentFlag' => true,
                ],
            ],
        ];

        if ($payment && $payment->poi_transaction_id) {
            $payload['PaymentRequest']['PaymentTransaction']['OriginalPOITransaction'] = [
                'POITransactionID' => [
                    'TransactionID' => $payment->poi_transaction_id,
                    'TimeStamp'     => $payment->poi_timestamp ?: now()->toIso8601String(),
                ],
            ];
        }

        try {
            $headers = $this->getRequestHeaders($restaurant);
            $url = $this->getBaseUrl($restaurant) . '/payment';

            $response = Http::withHeaders($headers)->timeout(60)->post($url, $payload);

            if ($response->successful()) {
                $resData = $response->json();
                $result = $resData['PaymentResponse']['Response']['Result'] ?? null;
                if (strtoupper($result) === 'SUCCESS') {
                    return [
                        'success' => true,
                        'raw'     => $resData,
                    ];
                }
            }

            return [
                'success' => false,
                'error'   => 'Refund declined on Verifone POS.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate Receipt Text with '#' separators for Nexo Printer
     */
    public function generateReceiptText(Order $order): string
    {
        $restaurant = $order->restaurant;
        $lines = [];

        // ============================================================
        // RESTAURANT HEADER
        // ============================================================

        $restaurantName = strtoupper($restaurant->name ?? 'RESTAURANT');

        $lines[] = "========================================";
        $lines[] = "          " . $restaurantName;
        
        if (!empty($restaurant->address)) {
            $lines[] = "      " . $restaurant->address;
        }

        if (!empty($restaurant->phone)) {
            $lines[] = "      Tel: " . $restaurant->phone;
        }

        $lines[] = "========================================";


        // ============================================================
        // ORDER INFORMATION
        // ============================================================

        $lines[] = "              ORDER RECEIPT";
        $lines[] = "----------------------------------------";

        $lines[] = sprintf(
            "%-12s: #%s",
            "Order",
            $order->id
        );

        $lines[] = sprintf(
            "%-12s: %s",
            "Date",
            $order->created_at
                ? $order->created_at->format('d/m/Y H:i:s')
                : date('d/m/Y H:i:s')
        );

        $lines[] = sprintf(
            "%-12s: %s",
            "Channel",
            strtoupper(
                str_replace(
                    '_',
                    ' ',
                    $order->order_from ?? 'POS'
                )
            )
        );

        $lines[] = sprintf(
            "%-12s: %s",
            "Type",
            strtoupper(
                str_replace(
                    '_',
                    ' ',
                    $order->order_type ?? 'Takeaway'
                )
            )
        );

        $lines[] = sprintf(
            "%-12s: %s",
            "Customer",
            $order->guest_name
                ?? $order->user?->name
                ?? 'Walk-in'
        );

        if (!empty($order->phone ?? $order->guest_phone)) {
            $lines[] = sprintf(
                "%-12s: %s",
                "Phone",
                $order->phone ?? $order->guest_phone
            );
        }

        $lines[] = "----------------------------------------";


        // ============================================================
        // ITEMS
        // ============================================================

        $lines[] = "ITEMS";
        $lines[] = "----------------------------------------";

        foreach ($order->items as $item) {

            $prodName = $item->product->name ?? 'Item';

            if (!empty($item->variant_name)) {
                $prodName .= ' (' . $item->variant_name . ')';
            }

            $itemName = substr($prodName, 0, 22);

            $qty = $item->quantity;

            $amt = number_format($item->total, 2);

            $lines[] = sprintf(
                "%-22s x%-2d £%6s",
                $itemName,
                $qty,
                $amt
            );

            // Addons
            if ($item->addons && $item->addons->count() > 0) {

                foreach ($item->addons as $addon) {

                    $lines[] =
                        "  + "
                        . substr($addon->addon_name, 0, 20)
                        . " (£"
                        . number_format($addon->price, 2)
                        . ")";
                }
            }
        }


        // ============================================================
        // BILL SUMMARY
        // ============================================================

        $lines[] = "----------------------------------------";
        $lines[] = "                 BILL";
        $lines[] = "----------------------------------------";

        $subtotal =
            (float) $order->total_amount
            - (float) $order->delivery_charge
            - (float) $order->service_charge;

        $lines[] = sprintf(
            "%-26s £%6s",
            "Subtotal:",
            number_format(max(0, $subtotal), 2)
        );

        if ($order->delivery_charge > 0) {
            $lines[] = sprintf(
                "%-26s £%6s",
                "Delivery Charge:",
                number_format($order->delivery_charge, 2)
            );
        }

        if ($order->service_charge > 0) {
            $lines[] = sprintf(
                "%-26s £%6s",
                "Service Charge:",
                number_format($order->service_charge, 2)
            );
        }

        if ($order->coupon_discount > 0) {
            $lines[] = sprintf(
                "%-26s -£%5s",
                "Coupon Discount:",
                number_format($order->coupon_discount, 2)
            );
        }

        $lines[] = "----------------------------------------";

        $lines[] = sprintf(
            "%-26s £%6s",
            "TOTAL AMOUNT:",
            number_format($order->total_amount, 2)
        );

        $lines[] = "----------------------------------------";


        // ============================================================
        // PAYMENT INFORMATION
        // ============================================================

        $lines[] = "               PAYMENT";
        $lines[] = "----------------------------------------";

        $lines[] = sprintf(
            "%-18s: %s",
            "Payment Status",
            strtoupper(
                $order->payment?->payment_status ?? 'PAID'
            )
        );

        $lines[] = sprintf(
            "%-18s: %s",
            "Payment Method",
            strtoupper(
                $order->payment_method ?? 'CARD'
            )
        );

        if ($order->payment && $order->payment->masked_pan) {

            $lines[] = sprintf(
                "%-18s: %s %s",
                "Card",
                $order->payment->card_brand ?? 'Card',
                $order->payment->masked_pan
            );

            if ($order->payment->auth_code) {

                $lines[] = sprintf(
                    "%-18s: %s",
                    "Auth Code",
                    $order->payment->auth_code
                );
            }

            if ($order->payment->poi_transaction_id) {

                $lines[] = sprintf(
                    "%-18s: %s",
                    "POI Tx ID",
                    $order->payment->poi_transaction_id
                );
            }
        }


        // ============================================================
        // FOOTER
        // ============================================================

        $lines[] = "----------------------------------------";
        $lines[] = "";
        $lines[] = "        Thank You For Your Visit!";
        $lines[] = "        We Hope To See You Again";
        $lines[] = "";
        $lines[] = "========================================";

        return implode('#', $lines);
    }
}