<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PatientList extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Patient::query(),
            )
            ->columns([
                TextColumn::make('name'),
            ]);
    }
}
