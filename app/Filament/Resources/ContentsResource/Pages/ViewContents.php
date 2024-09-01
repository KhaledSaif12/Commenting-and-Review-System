<?php

namespace App\Filament\Resources\ContentsResource\Pages;

use App\Filament\Resources\ContentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContents extends ViewRecord
{
    protected static string $resource = ContentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
