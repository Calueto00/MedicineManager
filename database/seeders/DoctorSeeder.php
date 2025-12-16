<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role','doctor')->first();
            Doctor::create([
                'user_id'=>$user->id,
                'especiality'=>'Clinico geral',
                'crm'=>'CRM-001',
                'bio'=>'medico com experiência em atendimento geral'
            ]);
    }
}
