<?php

namespace App\Filament\Resources\ContentsResource\Pages;

use App\Filament\Resources\ContentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContents extends EditRecord
{
    protected static string $resource = ContentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
