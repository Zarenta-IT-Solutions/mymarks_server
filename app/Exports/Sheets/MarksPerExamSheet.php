<?php
namespace App\Exports\Sheets;

use App\Models\Marks;
use App\Models\Setting;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use function Webmozart\Assert\Tests\StaticAnalysis\isArray;

class MarksPerExamSheet implements  WithTitle,FromView
{
    private $examId;

    private $classId;

    private $name;

    public function __construct(int $examId, $classId, string $name)
    {
        $this->examId = $examId;
        $this->classId = $classId;
        $this->name = $name;
    }


    public function view(): View
    {

        $setting = Setting::where('title','academic_year_id')->firstOrFail();
        $marks =  Marks::query()->where('exam_id',$this->examId)->where('class_id',request()->class_id)->where('academic_year_id',$setting->val)->orderBy('roll_number')->pluck('mark_data');
        return view('admin.school.excel')->with('marks',$marks)->with('keys',array_keys(($marks->first()!=null)?$marks->first():[]));
    }
    /**
     * @return Builder
     */
    public function query()
    {

    }

    /**
     * @return string
     */
    public function title(): string
    {
        return Str::slug($this->name);
    }
}
