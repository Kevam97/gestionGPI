<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ProjectsCompleted extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Proyectos cerrados';

    protected function getTableQuery(): Builder
    {
        return Project::where('status',1);
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
