<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\Restaurant;
use App\Services\WorldpayService;
use App\Http\Controllers\Front\OrderController;

class SyncPendingWorldpayPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worldpay:sync-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync pending Worldpay payments and reconcile orders for completed payments';

    protected WorldpayService $worldpay;

    public function __construct(WorldpayService $worldpay)
    {
        parent::__construct();
        $this->worldpay = $worldpay;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking pending Worldpay payments...');

        // Find payments pending for more than 5 minutes and less than 24 hours
        $pendingPayments = Payment::where('payment_status', 'pending')
            ->where('created_at', '<=', now()->subMinutes(5))
            ->where('created_at', '>=', now()->subHours(24))
            ->get();

        $count = 0;

        foreach ($pendingPayments as $payment) {
            try {
                $restaurant = Restaurant::find($payment->restaurant_id);
                if (!$restaurant || empty($restaurant->worldpay_username)) {
                    continue;
                }

                $accessToken = $this->worldpay->login($restaurant);
                $result = $this->worldpay->getHostedPaymentStatus($restaurant, $accessToken, $payment->transaction_id);

                if (($result['status'] ?? null) === 'PROCESSED_SUCCESSFUL') {

                    $paymentType = !empty($result['transaction']['card'])
                        ? 'card'
                        : (!empty($result['transaction']['bankAccount']) ? 'bank' : 'card');

                    $payment->update([
                        'payment_status'           => 'paid',
                        'payment_transaction_id'   => $result['transaction']['transactionId'] ?? null,
                        'secondary_transaction_id' => $result['transaction']['secondaryTransactionId'] ?? null,
                        'payment_method'           => $result['transaction']['paymentMethod'] ?? 'online',
                        'payment_type'             => $paymentType,
                    ]);

                    if ($payment->checkout_data) {
                        $data = json_decode($payment->checkout_data, true);
                        $request = new Request($data);

                        app(OrderController::class)->placeOrder($request, $payment);
                        $count++;
                        $this->info("Reconciled order for payment ID #{$payment->id}");
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Worldpay Sync Command Error for Payment #{$payment->id}: " . $e->getMessage());
            }
        }

        $this->info("Worldpay pending sync completed. {$count} payments reconciled.");
        return 0;
    }
}
