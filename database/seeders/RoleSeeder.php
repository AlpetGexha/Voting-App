<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = \Illuminate\Support\Facades\File::allFiles(app_path('Models'));
        // making a premission for each model
        $premision = [
            'create',
            'read',
            'update',
            'delete',
            'view',
        ];

        \Spatie\Permission\Models\Permission::create(['name' => 'admin_show']);

        foreach ($models as $model) {
            $model = str_replace('.php', '', $model->getFilename());
            foreach ($premision as $prem) {
                // check if premmision exsit
                if (! \Spatie\Permission\Models\Permission::where('name', strtolower($model).'_'.$prem)->exists()) {
                    \Spatie\Permission\Models\Permission::create(['name' => strtolower($model).'_'.$prem]);
                }
            }
        }
    }
}
