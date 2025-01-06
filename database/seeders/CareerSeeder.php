<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Career;

class CareerSeeder extends Seeder
{
    public function run()
    {
        Career::create([
            'referrer' => 'Juan Dela Cruz',
            'sub_agent' => 'Maria Santos',
            'broker' => 'Jose Rizal',
            'partner' => 'Emilio Aguinaldo',
            'position' => 'Real Estate Agent',
            'image' => 'uploads/careers/images/agent1.jpg',
        ]);

        Career::create([
            'referrer' => 'Luzviminda Cruz',
            'sub_agent' => 'Carlos Garcia',
            'broker' => 'Andres Bonifacio',
            'partner' => 'Gabriela Silang',
            'position' => 'Property Manager',
            'image' => 'uploads/careers/images/manager1.jpg',
        ]);

        Career::create([
            'referrer' => 'Ramon Magsaysay',
            'sub_agent' => 'Corazon Aquino',
            'broker' => 'Ferdinand Marcos',
            'partner' => 'Imelda Marcos',
            'position' => 'Marketing Specialist',
            'image' => 'uploads/careers/images/marketing1.jpg',
        ]);

        Career::create([
            'referrer' => 'Benigno Aquino',
            'sub_agent' => 'Leni Robredo',
            'broker' => 'Rodrigo Duterte',
            'partner' => 'Sara Duterte',
            'position' => 'Sales Consultant',
            'image' => 'uploads/careers/images/sales1.jpg',
        ]);

        Career::create([
            'referrer' => 'Isko Moreno',
            'sub_agent' => 'Manny Pacquiao',
            'broker' => 'Bongbong Marcos',
            'partner' => 'Cynthia Villar',
            'position' => 'Leasing Officer',
            'image' => 'uploads/careers/images/leasing1.jpg',
        ]);

        Career::create([
            'referrer' => 'Antonio Luna',
            'sub_agent' => 'Gregorio Del Pilar',
            'broker' => 'Diego Silang',
            'partner' => 'Melchora Aquino',
            'position' => 'Administrative Officer',
            'image' => 'uploads/careers/images/admin1.jpg',
        ]);
    }
}
