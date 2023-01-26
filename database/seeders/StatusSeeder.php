<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            'Open', 'Close', 'Considering', 'In Progress', 'Implemented',
        ];

        foreach ($status as $value) {
            Status::create([
                'name' => $value,
                'slug' => Str::slug($value),
            ]);
        }
    }
}
