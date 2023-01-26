<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reportable_type' => $this->faker->randomElement(['App\Models\Ideas', 'App\Models\Comments']),
            'reportable_id' => $this->faker->numberBetween(1, 50),
            'user_id' => $this->faker->numberBetween(1, 50),
            'subject' => $this->faker->word,
            'reason' => $this->faker->sentence,
            'is_resolved' => $this->faker->boolean(70),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
