<?php

namespace App\Exports;

use App\Models\Beneficiary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeneficiariesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Beneficiary::with(['kabupaten', 'kecamatan', 'desa', 'department'])
            ->get()
            ->map(function ($b) {
                return [
                    'No KK' => $b->family_card_number,
                    'Nama Kepala Keluarga' => $b->head_of_family,
                    'Jenis Kelamin' => $b->gender,
                    'Alamat' => $b->address,
                    'Kabupaten' => optional($b->kabupaten)->name,
                    'Kecamatan' => optional($b->kecamatan)->name,
                    'Desa' => optional($b->desa)->name,
                    'Bidang' => optional($b->department)->name,
                    'Tahun Bantuan' => $b->aid_year,
                    'Bulan Bantuan' => $b->aid_month,
                    'Status Bantuan' => $b->has_received_aid ? 'Sudah' : 'Belum',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No KK',
            'Nama Kepala Keluarga',
            'Jenis Kelamin',
            'Alamat',
            'Kabupaten',
            'Kecamatan',
            'Desa',
            'Bidang',
            'Tahun Bantuan',
            'Bulan Bantuan',
            'Status Bantuan',
        ];
    }
}
