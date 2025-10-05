<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'name' => 'Test Project',
                'description' => '',
                'link' => '',
                'update_link' => '',
                'expectations_description' => '',
                'profit_description' => '',
                'start_at' => '2023-05-01',
                'deadline' => '2023-09-01',
                'fts' => 100,
                'price' => 200,
                'profit' => 50,
                'deleted' => false,
            ]
        ];

        DB::table('projects')->insert($projects);
    }
}
