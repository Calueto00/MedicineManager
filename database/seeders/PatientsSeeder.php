<?php

namespace Database\Seeders;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role','patient')->first();
        Patients::create([
            'user_id'=>$user->id,
            'birth'=>'2000-01-01',
            'phone'=>'123456789',
            'address' => 'camama'
        ]);
    }
}
