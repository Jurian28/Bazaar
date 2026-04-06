<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        return [
            'advertisement_id' => Advertisement::factory()->sale(),
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
