<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\OfferBid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OfferBid>
 */
class OfferBidFactory extends Factory
{
    protected $model = OfferBid::class;

    public function definition(): array
    {
        return [
            'advertisement_id' => Advertisement::factory()->offer(),
            'user_id' => User::factory(),
            'price' => $this->faker->randomFloat(2, 1, 500),
            'accepted' => false,
        ];
    }

    public function accepted(): self
    {
        return $this->state(fn() => [
            'accepted' => true,
        ]);
    }
}
