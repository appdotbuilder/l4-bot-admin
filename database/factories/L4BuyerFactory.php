<?php

namespace Database\Factories;

use App\Models\L4Buyer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\L4Buyer>
 */
class L4BuyerFactory extends Factory
{
    protected $model = L4Buyer::class;

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
            'balance' => $this->faker->randomFloat(2, 0, 1000),
            'total_numbers_used' => $this->faker->numberBetween(0, 50),
            'last_activity' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the buyer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the buyer is banned.
     */
    public function banned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'banned',
        ]);
    }
}