<?php

namespace App\Filament\Resources\IdeasResource\Pages;

use App\Filament\Resources\IdeasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdeas extends EditRecord
{
    protected static string $resource = IdeasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
