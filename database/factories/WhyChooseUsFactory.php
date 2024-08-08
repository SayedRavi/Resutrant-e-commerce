<?php

namespace Database\Factories;

use App\Models\WhyChooseUs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhyChooseUs>
 */
class WhyChooseUsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'icon' => 'fa-solid fa-paperclip',
                'title' => fake()->sentence(10),
                'short_description' => fake()->sentence(),
                'status' => fake()->boolean()
        ];
    }
}
