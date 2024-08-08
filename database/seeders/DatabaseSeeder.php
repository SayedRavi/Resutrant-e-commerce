<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CouponFactory;
use Illuminate\Database\Seeder;
use function Carbon\call;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): DatabaseSeeder
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
        $this->call(UserSeeder::class);
        Slider::factory(4)->create();
        $this->call(WhyChooseUsTitleSeeder::class);
        Product::factory(5)->create();
        Coupon::factory(5)->create();
    }
}
