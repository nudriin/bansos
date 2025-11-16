<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\Department;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BeneficiariesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cari atau buat region berdasarkan nama
        $kabupaten = Region::firstOrCreate(
            ['name' => $row['kabupaten'], 'type' => 'kabupaten'],
            ['name' => $row['kabupaten'], 'type' => 'kabupaten']
        );

        $kecamatan = Region::firstOrCreate(
            ['name' => $row['kecamatan'], 'type' => 'kecamatan'],
            ['name' => $row['kecamatan'], 'type' => 'kecamatan', 'parent_id' => $kabupaten->id]
        );

        $desa = Region::firstOrCreate(
            ['name' => $row['desa'], 'type' => 'desa'],
            ['name' => $row['desa'], 'type' => 'desa', 'parent_id' => $kecamatan->id]
        );

        // Cari department berdasarkan nama
        $department = Department::firstOrCreate(
            ['name' => $row['bidang']],
            ['name' => $row['bidang']]
        );

        return new Beneficiary([
            'family_card_number' => $row['no_kk'],
            'head_of_family' => $row['nama_kepala_keluarga'],
            'gender' => $row['jenis_kelamin'],
            'address' => $row['alamat'],
            'has_received_aid' => $row['status_bantuan'] === 'Sudah' ? true : false,
            'aid_year' => $row['tahun_bantuan'],
            'aid_month' => $row['bulan_bantuan'],
            'department_id' => $department->id,
            'kabupaten_id' => $kabupaten->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'no_kk' => 'required',
            'nama_kepala_keluarga' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'bidang' => 'required',
        ];
    }
}
