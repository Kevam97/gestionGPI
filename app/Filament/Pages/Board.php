<?php

namespace App\Filament\Pages;

use App\Models\Objective;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
// use InvadersXX\FilamentKanbanBoard\Facades\FilamentKanbanBoard;

use InvadersXX\FilamentKanbanBoard\Pages\FilamentKanbanBoard;

class Board extends FilamentKanbanBoard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // public string $recordContentView = 'filament-kanban-board::record-content';

     protected function statuses() : Collection
    {
        return collect([
            [
                'id' => 'registered',
                'title' => 'Registered',
            ],
            [
                'id' => 'awaiting_confirmation',
                'title' => 'Awaiting Confirmation',
            ],
            [
                'id' => 'confirmed',
                'title' => 'Confirmed',
            ],
            [
                'id' => 'delivered',
                'title' => 'Delivered',
            ],
        ]);
    }

    // protected function records() : Collection
    // {
    //     return Objective::query()
    //     ->get()
    //     ->map(function ($item) {
    //         dd($item->id,);
    //         return [
    //             'id' => $item->id,
    //             'title' => $item->title,
    //             'status' => $item->status,
    //         ];
    //     });
    // }
}
