<?php

namespace App\Traits;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

trait ExcelTrait
{

    public function generate(Project $project)
    {
        $sheet = $this->loadTemplate();
        $this->fillProjectInfo($sheet, $project);
        $this->fillAnswers($sheet, $project);
        $fileRoute = $this->saveToFile($sheet, $project);

        return $fileRoute;
    }

    private function loadTemplate()
    {
        $reader = IOFactory::createReaderForFile(public_path('/excel/gantt_template.xlsx'));
        $reader->setIncludeCharts(true);
        return $reader->load(public_path('/excel/gantt_template.xlsx'));
    }

    private function fillProjectInfo($sheet, Project $project)
    {
        $worksheet = $sheet->getActiveSheet();
        $worksheet->getCell('B1')->setValue($project->name);
        $worksheet->getCell('B2')->setValue($project->company->name);
        $worksheet->getCell('B3')->setValue($project->user->pluck('name'));
        $worksheet->getCell('E3')->setValue(\PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel( $project->tasks[0]->start));
    }

    private function fillAnswers($sheet, Project $project)
    {
        $worksheet = $sheet->getActiveSheet();
        $j = 9;
        foreach ($project->tasks as  $task) {
            $worksheet->getCell('B'.$j)->setValue($task->name);
            $worksheet->getCell('C'.$j)->setValue($task->users->pluck('name'));
            $worksheet->getCell('D'.$j)->setValue(($task->status)? '100%' : '0%');
            $worksheet->getCell('E'.$j)->setValue(\PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($task->start));
            $worksheet->getCell('F'.$j)->setValue(\PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($task->end));

            $j++;
        }
    }

    private function saveToFile($sheet, Project $project)
    {
        Storage::disk('public')->makeDirectory('excel');
        $fileRoute = 'excel/'.$project->name.'.xlsx';
        $writer = IOFactory::createWriter($sheet, 'Xlsx');
        $writer->setIncludeCharts(true);
        $writer->save(public_path('storage/'.$fileRoute));
        return $fileRoute;
    }

}
