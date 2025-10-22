<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use Filament\Widgets\ChartWidget;

class BeneficiariesByDepartmentChart extends ChartWidget
{
    protected static ?string $heading = 'Penerima Bantuan per Bidang';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Department::withCount('beneficiaries')
            ->get()
            ->map(fn ($department) => [
                'name' => $department->name,
                'count' => $department->beneficiaries_count,
            ]);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Penerima',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                    ],
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}