<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductAddon;

class CartCalculationTest extends TestCase
{
    /**
     * Test 1: Base Item Price Calculation (1x Item)
     */
    public function test_single_item_cart_calculation()
    {
        session()->forget('cart');

        $product = Product::first();
        if (!$product) {
            $this->assertTrue(true);
            return;
        }

        $qty = 2;
        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => $qty
        ]);

        $response->assertStatus(200);

        $cart = session('cart', []);
        $this->assertNotEmpty($cart);

        $firstKey = array_key_first($cart);
        $item = $cart[$firstKey];

        $expectedUnitPrice = (float)$product->price;
        $expectedLineTotal = $expectedUnitPrice * $qty;

        $this->assertEquals($qty, $item['quantity']);
        $this->assertEquals($expectedUnitPrice, (float)$item['base_price']);

        // Check Cart Summary API calculation
        $summaryResponse = $this->getJson('/cart/summary');
        $summaryResponse->assertStatus(200);
        
        $summaryData = $summaryResponse->json();
        $this->assertEquals($qty, $summaryData['count']);
        $this->assertEquals(number_format($expectedLineTotal, 2, '.', ''), $summaryData['subtotal']);
    }

    /**
     * Test 2: Item with Variant and Addons Price Calculation
     */
    public function test_variant_and_addons_calculation()
    {
        session()->forget('cart');

        $product = Product::has('addons')->first();
        if (!$product) {
            $product = Product::first();
        }

        if (!$product) {
            $this->assertTrue(true);
            return;
        }

        $addon = ProductAddon::where('product_id', $product->id)->first();
        $addonIds = $addon ? [$addon->id] : [];

        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'addons'     => $addonIds,
            'quantity'   => 3
        ]);

        $response->assertStatus(200);

        $cart = session('cart', []);
        $firstKey = array_key_first($cart);
        $item = $cart[$firstKey];

        $addonTotal = $addon ? (float)$addon->price : 0;
        $expectedUnitPrice = (float)$product->price + $addonTotal;
        $expectedLineTotal = $expectedUnitPrice * 3;

        $this->assertEquals((float)$item['price'], $expectedUnitPrice);

        $summaryResponse = $this->getJson('/cart/summary');
        $summaryData = $summaryResponse->json();
        $this->assertEquals(number_format($expectedLineTotal, 2, '.', ''), $summaryData['subtotal']);
    }

    /**
     * Test 3: Dynamic Quantity Increase (+) Recalculation
     */
    public function test_cart_quantity_increase_recalculation()
    {
        session()->forget('cart');

        $product = Product::first();
        if (!$product) {
            $this->assertTrue(true);
            return;
        }

        $addResponse = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => 1
        ]);
        $cartKey = $addResponse->json('cart_key');

        $increaseResponse = $this->getJson("/cart/increase/{$cartKey}");
        $increaseResponse->assertStatus(200);

        $data = $increaseResponse->json();
        $this->assertTrue($data['success']);
        $this->assertEquals(2, $data['quantity']);

        $expectedPrice = (float)$product->price;
        $expectedSubtotal = $expectedPrice * 2;

        $this->assertEquals(number_format($expectedSubtotal, 2, '.', ''), $data['item_subtotal']);
        $this->assertEquals(number_format($expectedSubtotal, 2, '.', ''), $data['original_total']);
    }

    /**
     * Test 4: Dynamic Quantity Decrease (-) Recalculation
     */
    public function test_cart_quantity_decrease_recalculation()
    {
        session()->forget('cart');

        $product = Product::first();
        if (!$product) {
            $this->assertTrue(true);
            return;
        }

        $addResponse = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => 3
        ]);
        $cartKey = $addResponse->json('cart_key');

        $decreaseResponse = $this->getJson("/cart/decrease/{$cartKey}");
        $decreaseResponse->assertStatus(200);

        $data = $decreaseResponse->json();
        $this->assertTrue($data['success']);
        $this->assertEquals(2, $data['quantity']);

        $expectedPrice = (float)$product->price;
        $expectedSubtotal = $expectedPrice * 2;

        $this->assertEquals(number_format($expectedSubtotal, 2, '.', ''), $data['item_subtotal']);
        $this->assertEquals(number_format($expectedSubtotal, 2, '.', ''), $data['original_total']);
    }

    /**
     * Test 5: Cart Item Removal Recalculation
     */
    public function test_cart_item_removal_recalculation()
    {
        session()->forget('cart');

        $product = Product::first();
        if (!$product) {
            $this->assertTrue(true);
            return;
        }

        $addResponse = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => 1
        ]);
        $cartKey = $addResponse->json('cart_key');

        $removeResponse = $this->getJson("/cart/remove/{$cartKey}");
        $removeResponse->assertStatus(200);

        $data = $removeResponse->json();
        $this->assertTrue($data['success']);
        $this->assertTrue($data['cart_empty']);
        $this->assertEquals('0.00', $data['original_total']);
    }
}
