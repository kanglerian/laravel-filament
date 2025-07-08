<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class OwnerResource extends Resource {
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form( Form $form ): Form {
        return $form->schema( [
            Section::make( 'Owner Information' )
            ->description( 'Fill in the owner details' )
            ->schema( [
                TextInput::make( 'name' )->required()->columnSpan( 2 ),
                TextInput::make( 'email' )->email()->required(),
                TextInput::make( 'amount' ),
                TagsInput::make('tags'),
                TextInput::make( 'phone' )->prefix( '62' )->telRegex( '/^[0-9]{9,13}$/' )->mask( '999-9999-99999' )->required(),
                Toggle::make( 'is_active' )->onIcon( 'heroicon-o-user' )->offIcon( 'heroicon-m-user' )->onColor( 'success' )->offColor( 'danger' ) ] )
                ->columns( 2 ),
            ] );
        }

        public static function table( Table $table ): Table {
            return $table
            ->columns( [
                TextColumn::make( 'name' )->searchable()->sortable()->label( 'Owner Name' ),
                TextColumn::make( 'email' )->searchable()->label( 'Email' ),
                TextColumn::make( 'phone' )
                ->formatStateUsing( fn( $record ) => $record->getRawOriginal( 'phone' ) )
                ->searchable()
                ->url( fn ( $record ) => 'https://wa.me/' . $record->getRawOriginal( 'phone' ) )
                ->openUrlInNewTab()
                ->label( 'Phone' ),
                ToggleColumn::make( 'is_active' )->onColor( 'success' )->offColor( 'danger' )->label( 'Status' )
            ] )
            ->searchPlaceholder( 'Cari disini...' )
            ->filters( [
                //
            ] )
            ->actions( [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ] )
            ->bulkActions( [ Tables\Actions\BulkActionGroup::make( [ Tables\Actions\DeleteBulkAction::make() ] ) ] );
        }

        public static function getRelations(): array {
            return [
                //
            ];
        }

        public static function getPages(): array {
            return [
                'index' => Pages\ListOwners::route( '/' ),
                'create' => Pages\CreateOwner::route( '/create' ),
                'edit' => Pages\EditOwner::route( '/{record}/edit' ),
            ];
        }
    }
