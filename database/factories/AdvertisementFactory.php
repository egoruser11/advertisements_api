<?php

namespace Database\Factories;

use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ids = Type::pluck('id')->toArray();
        return [
            'city' => $this->faker->city(),
            'beds_count' => mt_rand(1, 4),
            'rooms_count' =>  mt_rand(1, 5),
            'guests_count' =>  mt_rand(1, 5),
            'address' => fake()->address(),
            'price' => mt_rand(1000,10000),
           'rules_cancellation' => null,
            'description' => null,
            'user_id' =>  $this->faker->randomElement($this->getUsersIds()),
            'type_id' => $this->faker->randomElement($ids),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function getUsersIds()
    {
        return User::pluck('id')->toArray();
    }
}
