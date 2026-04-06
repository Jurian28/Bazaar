<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Advertisement>
 */
class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['sale','rental','offer']),
        ];
    }

    public function sale(): self
    {
        return $this->state(fn() => ['type' => 'sale']);
    }

    public function rental(): self
    {
        return $this->state(fn() => ['type' => 'rental']);
    }

    public function offer(): self
    {
        return $this->state(fn() => ['type' => 'offer']);
    }
}
