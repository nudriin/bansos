<?php

namespace App\Filament\Widgets;

use App\Models\Region;
use Filament\Widgets\ChartWidget;

class BeneficiariesByRegionChart extends ChartWidget
{
    protected static ?string $heading = 'Penerima Bantuan per Kabupaten/Kota';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Region::where('type', 'kabupaten')
            ->withCount('beneficiariesKabupaten')
            ->get()
            ->map(fn ($region) => [
                'name' => $region->name,
                'count' => $region->beneficiaries_kabupaten_count,
            ]);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Penerima',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgb(54, 162, 235)',
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}