<?php

namespace App\Filament\Widgets;

use App\Models\Beneficiary;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBeneficiaries = Beneficiary::count();
        $receivedAid = Beneficiary::where('has_received_aid', true)->count();
        $notReceivedAid = Beneficiary::where('has_received_aid', false)->count();
        
        return [
            Stat::make('Total Penerima', $totalBeneficiaries)
                ->description('Jumlah total penerima bantuan')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Sudah Menerima', $receivedAid)
                ->description('Penerima yang sudah mendapat bantuan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Belum Menerima', $notReceivedAid)
                ->description('Penerima yang belum mendapat bantuan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}