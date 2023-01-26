<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Overtrue\LaravelLike\Like;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make like cache for comment

        foreach (range(1, 50) as $index) {
            Like::create([
                'user_id' => rand(0, 100),
                'likeable_id' => rand(0, 100),
                'likeable_type' => 'App\Models\Comments',
            ]);
        }
    }
}
