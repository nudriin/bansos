<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\Department;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;

class BeneficiariesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Kumpulkan baris yang di-skip karena duplikat
     *
     * Setelah import kamu bisa akses $import->getSkippedRows()
     */
    protected array $skippedRows = [];

    public function model(array $row)
    {
        $familyCard = $row['no_kk'] ?? null;
        $year       = $row['tahun_bantuan'] ?? null;
        $bidangName = $row['bidang'] ?? null;

        // buat / cari region
        $kabupaten = Region::firstOrCreate(
            ['name' => $row['kabupaten'], 'type' => 'kabupaten'],
            ['name' => $row['kabupaten'], 'type' => 'kabupaten']
        );

        $kecamatan = Region::firstOrCreate(
            ['name' => $row['kecamatan'], 'type' => 'kecamatan', 'parent_id' => $kabupaten->id],
            ['name' => $row['kecamatan'], 'type' => 'kecamatan', 'parent_id' => $kabupaten->id]
        );

        $desa = Region::firstOrCreate(
            ['name' => $row['desa'], 'type' => 'desa', 'parent_id' => $kecamatan->id],
            ['name' => $row['desa'], 'type' => 'desa', 'parent_id' => $kecamatan->id]
        );

        // cari / buat department
        $department = Department::firstOrCreate(
            ['name' => $bidangName],
            ['name' => $bidangName]
        );

        // jika salah satu nilai penting tidak ada, skip (atau bisa throw jika ingin mandatory)
        if (! $familyCard || ! $year || ! $department->id) {
            // simpan info skip untuk review
            $this->skippedRows[] = [
                'row' => $row,
                'reason' => 'Missing required field (no_kk / tahun_bantuan / bidang).'
            ];
            return null;
        }

        $exists = Beneficiary::where('family_card_number', $familyCard)
            ->where('aid_year', $year)
            ->where('department_id', $department->id)
            ->exists();

        if ($exists) {
            $this->skippedRows[] = [
                'row' => $row,
                'reason' => 'Duplicate: nomor KK sudah menerima bantuan di tahun & bidang yang sama.'
            ];

            return null;
        } else {
            return new Beneficiary([
                'family_card_number' => $familyCard,
                'head_of_family'     => $row['nama_kepala_keluarga'] ?? null,
                'gender'             => $row['jenis_kelamin'] ?? null,
                'address'            => $row['alamat'] ?? null,
                'has_received_aid'   => (isset($row['status_bantuan']) && strtolower($row['status_bantuan']) === 'sudah') ? true : false,
                'aid_year'           => $year,
                'aid_month'          => $row['bulan_bantuan'] ?? null,
                'department_id'      => $department->id,
                'kabupaten_id'       => $kabupaten->id,
                'kecamatan_id'       => $kecamatan->id,
                'desa_id'            => $desa->id,
                'user_id'            => Auth::id(),
            ]);
        }
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

    public function getSkippedRows(): array
    {
        return $this->skippedRows;
    }
}
