<?php

namespace App\Exports;

use App\Exports\Sheets\FormulaSheetImport;
use App\Exports\Sheets\MarksPerExamSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class StudentExport implements WithMultipleSheets
{
    use Exportable;

    protected $exams;
    public function __construct($exams)
    {
        $this->exams = $exams;
        
    }
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->exams as $exam) {
            $sheets[] = new MarksPerExamSheet($exam->id, $exam->name);
        }
        $sheets[] = new FormulaSheetImport();
        return $sheets;
    }

}
