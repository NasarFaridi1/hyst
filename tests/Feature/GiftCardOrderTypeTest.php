<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\GiftCard;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GiftCardOrderTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_blocks_gift_card_if_order_type_does_not_match()
    {
        $giftCard = GiftCard::create([
            'code' => 'DINEONLY100',
            'title' => 'Dine-In Special Gift Card',
            'amount' => 50,
            'balance' => 50,
            'status' => 'active',
            'applicable_type' => 'dine_in',
            'per_user_limit' => 1,
        ]);

        $sessionData = [
            'cart' => [
                1 => [
                    'product_id' => 1,
                    'name' => 'Pizza',
                    'quantity' => 1,
                    'base_price' => 20.00,
                    'addon_total' => 0.00,
                ]
            ]
        ];

        // 1. Try applying to delivery order
        $responseDelivery = $this->withSession($sessionData)
            ->postJson('/gift-card/apply', [
                'code' => 'DINEONLY100',
                'order_type' => 'delivery'
            ]);

        $responseDelivery->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'This Gift Card is only valid for Dine-In orders.'
            ]);

        // 2. Try applying to dine_in order
        $responseDineIn = $this->withSession($sessionData)
            ->postJson('/gift-card/apply', [
                'code' => 'DINEONLY100',
                'order_type' => 'dine_in'
            ]);

        $responseDineIn->assertStatus(200)
            ->assertJson([
                'success' => true,
                'gift_card' => 'DINEONLY100',
                'discount' => '20.00'
            ]);
    }
}
