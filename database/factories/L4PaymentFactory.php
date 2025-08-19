<?php

namespace Database\Factories;

use App\Models\L4Payment;
use App\Models\L4Buyer;
use App\Models\L4Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\L4Payment>
 */
class L4PaymentFactory extends Factory
{
    protected $model = L4Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['credit', 'debit']);
        
        return [
            'buyer_id' => L4Buyer::factory(),
            'invoice_id' => $this->faker->optional()->passthrough(L4Invoice::factory()),
            'amount' => $this->faker->randomFloat(2, 1, 500),
            'type' => $type,
            'method' => $this->faker->randomElement(['crypto', 'bank_transfer', 'paypal', 'stripe']),
            'transaction_id' => $this->faker->optional()->uuid,
            'description' => $type === 'credit' ? 'Account top-up' : 'Number rental payment',
            'metadata' => [
                'ip_address' => $this->faker->ipv4,
                'user_agent' => $this->faker->userAgent,
            ],
        ];
    }

    /**
     * Indicate that the payment is a credit.
     */
    public function credit(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'credit',
            'description' => 'Account top-up',
            'invoice_id' => null,
        ]);
    }

    /**
     * Indicate that the payment is a debit.
     */
    public function debit(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'debit',
            'description' => 'Number rental payment',
        ]);
    }
}