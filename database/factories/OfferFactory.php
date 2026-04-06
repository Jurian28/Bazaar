<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
 */
class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        $end = $this->faker->dateTimeBetween('+1 day', '+1 month');
        return [
            'advertisement_id' => Advertisement::factory()->offer(),
            'start_price' => $this->faker->randomFloat(2, 1, 500),
            'end_date' => $end->format('Y-m-d'),
        ];
    }
}
