<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\BeneficiariesByDepartmentChart;
use App\Filament\Widgets\BeneficiariesByRegionChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 0;

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         DashboardStatsOverview::class,
    //         BeneficiariesByDepartmentChart::class,
    //         BeneficiariesByRegionChart::class,
    //     ];
    // }
    
}
