<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name','Admin'))->first();

        Project::insert([
            ['name' => 'Website Redesign', 'description' => 'Redesign company website', 'created_by' => $admin->id, 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Marketing Campaign', 'description' => 'Launch social media ads', 'created_by' => $admin->id, 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'New App Development', 'description' => 'Build mobile app', 'created_by' => $admin->id, 'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
