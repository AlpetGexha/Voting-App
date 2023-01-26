<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ideas>
 */
class IdeasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => rand(1, 5),
            'status_id' => rand(1, 5),
            'title' => str()->title($this->faker->sentence),
            'slug' => $this->faker->slug,
            'body' => $this->faker->sentence(14),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
