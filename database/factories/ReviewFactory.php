<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_sender_id' => User::factory(),
            'user_id' => null,
            'advertisement_id' => Advertisement::factory(),
            'rating' => (string) $this->faker->numberBetween(1,5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
