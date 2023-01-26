<?php

namespace App\Filament\Resources\IdeasResource\Pages;

use App\Filament\Resources\IdeasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdeas extends ListRecords
{
    protected static string $resource = IdeasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
