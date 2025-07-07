<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Filament\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Patient Information')
                    ->description('Fill in the patient details')
                    ->schema([
                        DatePicker::make('date_of_birth')->required()->maxDate(now())->label('Date of Birth'),
                        TextInput::make('name')->required()->label('Name'),
                        Select::make('type')->options([
                            'cat' => 'Cat',
                            'dog' => 'Dog',
                            'bird' => 'Bird',
                            'reptile' => 'Reptile',
                            'other' => 'Other',
                        ])->required()->label('Type'),
                        Select::make('owner_id')
                            ->relationship('owner', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->label('Owner'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->label('Patient Name'),
                TextColumn::make('type')->label('Type'),
                TextColumn::make('date_of_birth')->sortable()->label('Date of Birth'),
                TextColumn::make('owner.name')->label('Owner')->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'bird' => 'Bird',
                        'reptile' => 'Reptile',
                        'other' => 'Other',
                    ])
                    ->label('Type'),
                    SelectFilter::make('owner_id')
                    ->relationship('owner', 'name')
                    ->label('Owner'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
