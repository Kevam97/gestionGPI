<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ProjectsInProccess extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Project::where('status',0);
    }

    protected function getTableColumns(): array
    {
        return [
        Tables\Columns\TextColumn::make('company.name')
            ->searchable(),
        Tables\Columns\TextColumn::make('name')
            ->searchable(),
        Tables\Columns\TextColumn::make('amount')
            ->formatStateUsing(fn (int $state): string => '$'.number_format($state,0))
            ->searchable(),
        ];
    }
}
