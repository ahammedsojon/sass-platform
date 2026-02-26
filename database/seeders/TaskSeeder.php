<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::whereHas('roles', fn($q) => $q->where('name','User'))->get();

        Task::insert([
            ['title'=>'Design Mockups','description'=>'Create homepage mockups','project_id'=>$projects[0]->id,'assigned_to'=>$users[0]->id,'status'=>'in_progress','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Develop Landing Page','description'=>'Code landing page HTML/CSS','project_id'=>$projects[0]->id,'assigned_to'=>$users[1]->id,'status'=>'pending','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Social Ads Setup','description'=>'Setup Facebook ads','project_id'=>$projects[1]->id,'assigned_to'=>$users[0]->id,'status'=>'completed','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'App Backend','description'=>'Setup Laravel backend','project_id'=>$projects[2]->id,'assigned_to'=>$users[1]->id,'status'=>'in_progress','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
