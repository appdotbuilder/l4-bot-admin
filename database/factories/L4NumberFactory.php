<?php

namespace Database\Factories;

use App\Models\L4Number;
use App\Models\L4Seller;
use App\Models\L4Buyer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\L4Number>
 */
class L4NumberFactory extends Factory
{
    protected $model = L4Number::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = [
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'GB', 'name' => 'United Kingdom'],
            ['code' => 'DE', 'name' => 'Germany'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'RU', 'name' => 'Russia'],
            ['code' => 'IN', 'name' => 'India'],
            ['code' => 'CN', 'name' => 'China'],
            ['code' => 'BR', 'name' => 'Brazil'],
        ];

        $country = $this->faker->randomElement($countries);
        $status = $this->faker->randomElement(['available', 'rented', 'completed', 'cancelled', 'expired']);
        
        return [
            'phone_number' => $this->faker->unique()->phoneNumber,
            'country_code' => $country['code'],
            'country_name' => $country['name'],
            'seller_id' => L4Seller::factory(),
            'buyer_id' => $status === 'available' ? null : L4Buyer::factory(),
            'status' => $status,
            'price' => $this->faker->randomFloat(2, 1, 50),
            'service' => $this->faker->optional()->randomElement(['WhatsApp', 'Telegram', 'Discord', 'Instagram', 'Facebook']),
            'sms_codes' => $status === 'completed' ? $this->faker->optional()->numerify('######') : null,
            'rented_at' => in_array($status, ['rented', 'completed', 'cancelled']) ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
            'expires_at' => $status === 'rented' ? $this->faker->dateTimeBetween('now', '+1 hour') : null,
            'completed_at' => in_array($status, ['completed', 'cancelled', 'expired']) ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
        ];
    }

    /**
     * Indicate that the number is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
            'buyer_id' => null,
            'rented_at' => null,
            'expires_at' => null,
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the number is rented.
     */
    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rented',
            'buyer_id' => L4Buyer::factory(),
            'rented_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 hour'),
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the number is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'buyer_id' => L4Buyer::factory(),
            'rented_at' => $this->faker->dateTimeBetween('-1 week', '-1 day'),
            'expires_at' => null,
            'completed_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'sms_codes' => $this->faker->numerify('######'),
        ]);
    }
}