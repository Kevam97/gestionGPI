<?php

namespace App\Filament\Resources\BoardResource\Pages;

use App\Filament\Resources\BoardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoard extends EditRecord
{
    protected static string $resource = BoardResource::class;

    protected function getActions(): array
    {
        return [

        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function getFormTabLabel(): ?string
    {
        return 'Proyecto';
    }

}
