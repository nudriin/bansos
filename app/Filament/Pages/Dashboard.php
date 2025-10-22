<?php

namespace App\Filament\Pages;

use App\Models\Beneficiary;
use App\Models\Department;
use App\Models\Region;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\BeneficiariesByDepartmentChart;
use App\Filament\Widgets\BeneficiariesByRegionChart;
use Illuminate\Support\Facades\DB;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?int $navigationSort = 0;

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardStatsOverview::class,
            BeneficiariesByDepartmentChart::class,
            BeneficiariesByRegionChart::class,
        ];
    }
}
