<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Foundation\Testing\WithFaker;

class AdminAndRestaurantPanelTest extends TestCase
{
    /**
     * Test 1: Super Admin Access Guard (Guest Redirect)
     */
    public function test_guest_cannot_access_super_admin_dashboard()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test 2: Restaurant Admin Access Guard (Guest & Non-Admin Block)
     */
    public function test_guest_cannot_access_restaurant_admin_dashboard()
    {
        $response = $this->get('/restaurant/dashboard');
        $response->assertStatus(302);

        // Test regular customer access gets blocked (403)
        $customer = User::factory()->make(['role' => 'user']);
        $response = $this->actingAs($customer)->get('/restaurant/dashboard');
        $response->assertStatus(403);
    }

    /**
     * Test 3: Super Admin Dashboard & Management Routes
     */
    public function test_super_admin_dashboard_and_resources()
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $admin = User::factory()->make(['role' => 'super_admin']);
        }

        $this->actingAs($admin);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);

        $response = $this->get('/admin/restaurants');
        $response->assertStatus(200);

        $response = $this->get('/admin/orders');
        $response->assertStatus(200);

        $response = $this->get('/admin/restaurant-categories');
        $response->assertStatus(200);
    }

    /**
     * Test 4: Restaurant Admin Dashboard & Order Management Routes
     */
    public function test_restaurant_admin_dashboard_and_resources()
    {
        $restaurant = Restaurant::first();
        $restaurantAdmin = User::where('role', 'restaurant_admin')->first();

        if (!$restaurantAdmin) {
            $restaurantAdmin = User::factory()->make([
                'role'          => 'restaurant_admin',
                'restaurant_id' => $restaurant ? $restaurant->id : 1
            ]);
        }

        $this->actingAs($restaurantAdmin);

        $response = $this->get('/restaurant/dashboard');
        $response->assertStatus(200);

        $response = $this->get('/restaurant/orders');
        $response->assertStatus(200);

        $response = $this->get('/restaurant/items');
        $response->assertStatus(200);

        $response = $this->get('/restaurant/categories');
        $response->assertStatus(200);

        $response = $this->get('/restaurant/offers');
        $response->assertStatus(200);
    }
}
