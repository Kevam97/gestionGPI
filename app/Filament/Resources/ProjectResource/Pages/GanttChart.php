<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Traits\ExcelTrait;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Page;

class GanttChart extends EditRecord
{
    use ExcelTrait;

    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.gantt-chart';

    protected function getTitle(): string
    {

        return __('Diagrama Gantt');
    }

    protected function getActions(): array
    {
        return [
            Action::make('Excel Gantt')
                ->action(fn()=>$this->generate($this->record))
        ];
    }


    public function mount($record): void
    {
        parent::mount($record);
    }
}
