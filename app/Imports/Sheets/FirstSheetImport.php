<?php

namespace App\Imports\Sheets;

use App\Models\Marks;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
class FirstSheetImport implements ToModel, WithHeadingRow
{

    protected $examId;

    protected $academic_id;

    public function __construct($id,$academic_id)
    {
        $this->examId = $id;
        $this->academic_id = $academic_id;
    }


    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        dd($row);
        $mark = Marks::where('exam_id',$this->examId)->where('academic_year_id',$this->academic_id)->where('user_id',$row['id'])->first();
        if($mark) {
            $mark->update(['calculate_data' => $row]);
        }
    }
}
