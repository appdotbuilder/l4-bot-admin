<?php

namespace Database\Factories;

use App\Models\L4Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\L4Seller>
 */
class L4SellerFactory extends Factory
{
    protected $model = L4Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'telegram_id' => $this->faker->unique()->numerify('##########'),
            'username' => $this->faker->optional()->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'status' => $this->faker->randomElement(['active', 'banned']),
            'balance' => $this->faker->randomFloat(2, 0, 5000),
            'total_numbers_sold' => $this->faker->numberBetween(0, 100),
            'commission_rate' => $this->faker->randomFloat(2, 5, 20),
            'last_activity' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the seller is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the seller is banned.
     */
    public function banned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'banned',
        ]);
    }
}