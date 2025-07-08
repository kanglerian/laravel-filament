<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PatientTypeOverview;
use Filament\Pages\Page;

class Settings extends Page {
    protected ?string $heading = 'Custom Page Heading';
    protected ?string $subheading = 'Custom Page Subheading';
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';

    protected function getHeaderWidgets(): array {
        return [
            PatientTypeOverview::class,
        ];
    }
}
