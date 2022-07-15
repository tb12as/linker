<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'original_link' => fake()->url(),
            'unique_code' => alphaID(rand(1e9, 1e14)),
            'title' => fake()->sentence(3),
            'expire_at' => now()->addDays(14)->endOfDay(),
        ];
    }
}
