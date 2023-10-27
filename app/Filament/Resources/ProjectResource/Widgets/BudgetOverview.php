<?php

namespace App\Filament\Resources\ProjectResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class BudgetOverview extends Widget
{
    protected static string $view = 'filament.resources.project-resource.widgets.budget-overview';

    public ?Model $record = null;
}
