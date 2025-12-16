<?php

namespace Database\Seeders;

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
        //admin
        User::create([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('passord'),
            'role'=>'admin'
        ]);

        //doctor
        User::create([
            'name'=>'Dr. Calueto',
            'email'=>'calueto@gmail.com',
            'password'=>Hash::make('passord'),
            'role'=>'doctor'
        ]);

        //patient
        User::create([
            'name'=>'Francisco',
            'email'=>'francisco@gmail.com',
            'password'=>Hash::make('passord'),
            'role'=>'patient'
        ]);
    }
}
