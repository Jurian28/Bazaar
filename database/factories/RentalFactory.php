<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rental>
 */
class RentalFactory extends Factory
{
    protected $model = Rental::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('now', '+1 week');
        $end = (clone $start)->modify('+7 days');
        return [
            'advertisement_id' => Advertisement::factory()->rental(),
            'price_per_day' => $this->faker->randomFloat(2, 1, 100),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
        ];
    }
}
