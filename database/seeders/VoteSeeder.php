<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Make random votes user_id and ideas_id must be unique
        foreach (range(1, 300) as $num) {
            // $user_id = \App\Models\User::;
            // random user id
            $user_id = \App\Models\User::inRandomOrder()->first()->id;
            $ideas_id = \App\Models\Ideas::inRandomOrder()->first()->id;
            $vote = \App\Models\Vote::where('user_id', $user_id)->where('ideas_id', $ideas_id)->first();
            if (! $vote) {
                \App\Models\Vote::create([
                    'user_id' => $user_id,
                    'ideas_id' => $ideas_id,
                    // created_at random time by now and 3 mouth ago
                    'created_at' => \Carbon\Carbon::now()->subMonths(rand(0, 3))->subDays(rand(0, 30))->subHours(rand(0, 24))->subMinutes(rand(0, 60))->subSeconds(rand(0, 60)),
                    'updated_at' => \Carbon\Carbon::now()->subMonths(rand(0, 3))->subDays(rand(0, 30))->subHours(rand(0, 24))->subMinutes(rand(0, 60))->subSeconds(rand(0, 60)),
                ]);
            }
        }
    }
}
