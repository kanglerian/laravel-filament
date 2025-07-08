<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget {

    protected static ?string $pollingInterval = '10s';
    protected ?string $heading = 'Analytics';
    protected ?string $description = 'An overview of some analytics.';

    protected function getStats(): array {
        return [
            Stat::make( 'Jumlah Dog', Patient::query()->where( 'type', 'dog' )->count() )->description( 'Total number of dog patients' )->descriptionIcon( 'heroicon-m-arrow-trending-up', IconPosition::After )->color( 'success' ),
            Stat::make( 'Unique views', '192.1k' )
            ->description( '32k increase' )
            ->descriptionIcon( 'heroicon-m-arrow-trending-up' )
            ->chart( [ 7, 2, 10, 3, 15, 4, 17 ] )
            ->color( 'success' ),
        ];
    }
}
