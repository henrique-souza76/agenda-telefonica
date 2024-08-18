<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ddd = $this->faker->numberBetween(10, 99);
        $number_pt1 = $this->faker->numberBetween(90000, 99999);
        $number_pt2 = $this->faker->numberBetween(1000, 9999);

        return [
            'name' => fake()->name(),
            'phone' => sprintf("(%02d) %05d-%04d", $ddd, $number_pt1, $number_pt2),
            'email' => fake()->safeEmail(),
            'creator_user_id' => 1
        ];
    }
}
