<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            'Rehabilitasi Sosial (Resos)',
            'Perlindungan Sosial Korban Bencana',
            'Panti Anak Putus Sekolah',
            'Panti Karya Wanita',
            'Panti Jompo',
            'Panti Gangguan Jiwa dan Penanganan Fakir Miskin',
        ];

        foreach ($departments as $department) {
            Department::create(['name' => $department]);
        }
    }
}
