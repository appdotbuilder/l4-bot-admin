<?php

namespace Database\Factories;

use App\Models\L4Invoice;
use App\Models\L4Buyer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\L4Invoice>
 */
class L4InvoiceFactory extends Factory
{
    protected $model = L4Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $numbersCount = $this->faker->numberBetween(1, 10);
        $totalAmount = $this->faker->randomFloat(2, 5, 200);
        
        return [
            'invoice_number' => 'INV-' . $invoiceDate->format('Ymd') . '-' . $this->faker->numberBetween(1000, 9999),
            'buyer_id' => L4Buyer::factory(),
            'invoice_date' => $invoiceDate,
            'total_amount' => $totalAmount,
            'numbers_count' => $numbersCount,
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
            'paid_at' => $this->faker->optional(0.3)->dateTimeBetween($invoiceDate, 'now'),
            'description' => 'Daily usage invoice for ' . $invoiceDate->format('F j, Y'),
            'line_items' => [
                [
                    'phone_number' => $this->faker->phoneNumber,
                    'country' => $this->faker->country,
                    'service' => $this->faker->randomElement(['WhatsApp', 'Telegram', 'Discord']),
                    'price' => $this->faker->randomFloat(2, 1, 25),
                    'rented_at' => $invoiceDate->format('Y-m-d H:i:s'),
                ],
            ],
        ];
    }

    /**
     * Indicate that the invoice is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'paid_at' => null,
        ]);
    }

    /**
     * Indicate that the invoice is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => $this->faker->dateTimeBetween($attributes['invoice_date'] ?? '-1 week', 'now'),
        ]);
    }

    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'paid_at' => null,
            'invoice_date' => $this->faker->dateTimeBetween('-2 months', '-1 month'),
        ]);
    }
}