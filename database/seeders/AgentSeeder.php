<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User();
        $user->name= 'Agent';
        $user->email='agent@gmail.com';
        $user->password = bcrypt('password');
        // verify email now 
        $user->email_verified_at = now();
        $user->role='agent';
        $user->save();
        $user->assignRole('agent');
    }
}
