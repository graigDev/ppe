<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'      =>  'soulcode',
            'email'     =>  'demo@email.com',
            'password'  =>  Hash::make('password')
        ]);

        $team = Team::create([
            'user_id'  =>  $user->id,
            'name'     =>  config('app.name'),
        ]);

        $user->teams()->attach($team->id);
        $user->roles()->attach(1);

    }
}
