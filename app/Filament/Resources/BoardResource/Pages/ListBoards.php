<?php

namespace App\Filament\Resources\BoardResource\Pages;

use App\Filament\Resources\BoardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoards extends ListRecords
{
    protected static string $resource = BoardResource::class;

    protected function getActions(): array
    {
        return [

        ];
    }
}
