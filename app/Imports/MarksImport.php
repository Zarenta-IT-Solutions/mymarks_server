<?php

namespace App\Imports;

use App\Imports\Sheets\FirstSheetImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MarksImport implements WithMultipleSheets
{

    protected $examId;

    protected $academic_id;

    public function __construct($id,$academic_id)
    {
        $this->examId = $id;
        $this->academic_id = $academic_id;
    }


    public function sheets(): array
    {
        return [
            'Sheet1' => new FirstSheetImport($this->examId, $this->academic_id),
        ];
    }

}
