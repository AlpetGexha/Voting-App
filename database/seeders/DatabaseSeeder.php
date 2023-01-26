<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            StatusSeeder::class,
            // CategorieSeeder::class,
        ]);

        \App\Models\User::factory(200)->create();
        \App\Models\Categorie::factory(10)->create();
        // \App\Models\Status::factory(5)->create();
        \App\Models\Ideas::factory(100)->create();
        \App\Models\Comments::factory(200)->create();
        \App\Models\Spam::factory(40)->create();
        \App\Models\Report::factory(100)->create();

        // \App\Models\Vote::factory(40)->create();

        $this->call([
            LikeSeeder::class,
            VoteSeeder::class,
        ]);

        $this->call([
            Artisan::call('shield:install'),
            Artisan::call('optimize:clear'),
        ]);
    }
}
