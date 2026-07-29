<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductAddon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemE2ETest extends TestCase
{
    /**
     * Test 1: Home Page & Restaurant Listing Load
     */
    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('HYST');
    }

    /**
     * Test 2: Ambassador and Restaurant Partner Landing Pages
     */
    public function test_partner_pages_load_successfully()
    {
        $response = $this->get('/become-ambassador');
        $response->assertStatus(200);

        $response = $this->get('/become-a-partner');
        $response->assertStatus(200);
    }

    /**
     * Test 3: Restaurant Open/Closed Status Attribute
     */
    public function test_restaurant_is_open_attribute()
    {
        $restaurant = Restaurant::first();
        if ($restaurant) {
            $this->assertIsBool($restaurant->is_open);
        } else {
            $this->assertTrue(true);
        }
    }

    /**
     * Test 4: Guest Add to Cart via AJAX API
     */
    public function test_guest_can_add_item_to_cart()
    {
        $product = Product::first();
        if (!$product) {
            $this->assertTrue(true);
            return;
        }

        $response = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity'   => 1
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'cart_key',
            'count'
        ]);
        $this->assertTrue(session()->has('cart'));
    }

    /**
     * Test 5: Cart Summary API
     */
    public function test_cart_summary_api()
    {
        $response = $this->getJson('/cart/summary');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'items',
            'count',
            'subtotal'
        ]);
    }

    /**
     * Test 6: Cart Page Renders
     */
    public function test_cart_page_renders()
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    /**
     * Test 7: Unauthenticated Checkout Access Redirects to Login with Intent
     */
    public function test_unauthenticated_checkout_redirects_to_login()
    {
        $product = Product::first();
        if ($product) {
            $this->postJson('/cart/add', [
                'product_id' => $product->id,
                'quantity'   => 1
            ]);
        }

        $response = $this->get('/checkout');
        $response->assertStatus(302);
        $response->assertRedirect('/login?redirect=' . urlencode('/checkout'));
    }

    /**
     * Test 8: PWA Manifest Route
     */
    public function test_pwa_manifest_route()
    {
        $response = $this->get('/manifest.json');
        if ($response->status() === 404) {
            // Check laravelpwa route name
            $response = $this->get(route('laravelpwa.manifest'));
        }
        $response->assertStatus(200);
    }

    /**
     * Test 9: PWA Service Worker & Offline Route
     */
    public function test_pwa_offline_route()
    {
        $response = $this->get('/offline');
        $response->assertStatus(200);
    }
}
