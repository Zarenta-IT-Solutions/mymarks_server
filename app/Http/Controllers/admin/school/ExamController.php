<?php

namespace App\Http\Controllers\admin\school;

use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Marks;
use App\Models\Setting;
use App\Models\StudentAcademicYear;
use App\Models\User;
use App\msGraph\Workbook;
use Illuminate\Http\Request;
use DocxMerge\DocxMerge;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;


class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::where('title','academic_year_id')->firstOrFail();
        if(\request()->has('mark_id')){
            $exam = Exam::findOrFail(\request()->id);

            $mark = Marks::findOrFail(\request()->mark_id);
            $acedmic = StudentAcademicYear::where('user_id',$mark->user_id)->where('academic_id', $setting->val)->first();
            $data = array_merge($mark->user->toArray(), array('roll_number' => $acedmic->roll_number,'medium'=>ucfirst($mark->user->medium->name),'dobw'=>DOBinWord($mark->user->date_of_birth),'session'=>$acedmic->academic->year_range,'class_name'=>$exam->my_class->name), (array)$mark->calculate_data);
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(\Storage::url($exam->template));
            $templateProcessor->setImageValue('avatar', array('src' => $mark->user['avatar'], 'height' => '100', 'width' => '100'));
            $templateProcessor->setValues($data);
            $templateProcessor->saveAs( $acedmic->roll_number . '.docx');
            return response()->download($acedmic->roll_number . '.docx')->deleteFileAfterSend(true);
        }
        $exam = Exam::findOrFail(\request()->id);
        $marks = Marks::where('academic_year_id',$setting->val)->where('exam_id',$exam->id)->where('class_id',$exam->class_id)->get();
        $temDirectory = 'temp/';
        if (!file_exists($temDirectory)) {
            mkdir($temDirectory, 0777, true);
        }
        $files = array();
        foreach($marks as $k=>$mark){
            $user = User::where('id',$mark->user_id)->select('name','email','password','address','mobile','date_of_birth','current_academic_year_id','gender','about','avatar','address','blood_group','mother_name','father_name','aadhar','cast','family_id','sssm_id','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account','sambal')->first();
            if($user) {
                $acedmic = StudentAcademicYear::where('user_id',$mark->user_id)->where('academic_id', $setting->val)->first();
                $data = array_merge($mark->user->toArray(), array('roll_number' => $acedmic->roll_number,'medium'=>ucfirst($mark->user->medium->name),'dobw'=>DOBinWord($mark->user->date_of_birth),'session'=>$acedmic->academic->year_range,'class_name'=>$exam->my_class->name), (array)$mark->calculate_data);
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(\Storage::url($exam->template));
                $templateProcessor->setImageValue('avatar', array('src' => $user['avatar'], 'height' => '100', 'width' => '100'));
                $templateProcessor->setValues($data);
                $templateProcessor->saveAs($temDirectory . $acedmic->roll_number . '.docx');
                array_push($files,$temDirectory . $acedmic->roll_number . '.docx');
            }
        }
        $dm = new DocxMerge();
        $dm->merge($files,'result.docx');
        \File::deleteDirectory(public_path($temDirectory));
        return response()->download('result.docx')->deleteFileAfterSend(true);
        
    }


    public function rollPrint($id)
    {
        $setting = Setting::where('title','academic_year_id')->firstOrFail();
         $exam = Exam::findOrFail(\request()->id);
        $marks = Marks::where('academic_year_id',$setting->val)->where('exam_id',$exam->id)->where('class_id',$exam->class_id)->get();
          $temDirectory = 'temp/';
        if (!file_exists($temDirectory)) {
            mkdir($temDirectory, 0777, true);
        }
        $files = array();
        foreach($marks as $k=>$mark){
            $user = User::where('id',$mark->user_id)->select('name','email','password','address','mobile','date_of_birth','current_academic_year_id','gender','about','avatar','address','blood_group','mother_name','father_name','aadhar','cast','family_id','sssm_id','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account','sambal')->first();
             if($user) {
                $acedmic = StudentAcademicYear::where('user_id',$mark->user_id)->where('academic_id', $setting->val)->first();
                $data = array_merge($mark->user->toArray(), array('roll_number' => $acedmic->roll_number,'medium'=>ucfirst($mark->user->medium->name),'dobw'=>DOBinWord($mark->user->date_of_birth),'session'=>$acedmic->academic->year_range,'class_name'=>$exam->my_class->name), (array)$mark->calculate_data);
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(\Storage::url($exam->template));
                $templateProcessor->setImageValue('avatar', array('src' => $user['avatar'], 'height' => '100', 'width' => '100'));
                $templateProcessor->setValues($data);
                $templateProcessor->saveAs($temDirectory . $acedmic->roll_number . '.docx');
                array_push($files,$temDirectory . $acedmic->roll_number . '.docx');
            }
        }
        $dm = new DocxMerge();
        $dm->merge($files,'rollNumber.docx');
        \File::deleteDirectory(public_path($temDirectory));
        return response()->download('rollNumber.docx')->deleteFileAfterSend(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = Setting::where('title','academic_year_id')->firstOrFail();
        $exam = Exam::findOrFail(\request()->exam_id);
        $exams = Exam::where('academic_year_id', $setting->val)->select('name', 'id')->where('class_id', \request()->class_id)->get();
        return (new StudentExport($exams))->download($exam->name.'.xlsx');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
            'data' => 'required',
        ]);
        $exam = Exam::findOrFail($request->exam_id);
        $setting = Setting::where('title','academic_year_id')->firstOrFail();

        foreach (json_decode($request->data, true) as $data)
        {
            $mark = Marks::where('exam_id',$exam->id)->where('academic_year_id',$setting->val)->where('user_id',$data['id'])->update(['calculate_data' => $data]);
        }

        if($request->hasFile('file')){
//            Excel::import(new MarksImport($exam->id, $setting->val), request()->file('file'));
            if($exam->excel!=null && Storage::has($exam->excel)) {
                Storage::delete($exam->excel);
            }
            $path = $request->file('file')->storePublicly($request->session()->get('slug').'/'.'excel');
            $exam->update(['excel'=>$path]);
        }
        \Session::flash('message', 'File Upload Successfully');
        \Session::flash('alert-class', 'bg-green-400');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = Setting::where('title','academic_year_id')->firstOrFail();
        $exam = Exam::findOrFail($id);
        $marks = Marks::where('academic_year_id',$setting->val)->where('exam_id',$exam->id)->where('class_id',$exam->class_id)->get();
        return view('admin.school.exam.show')->with('exam',$exam)->with('marks',$marks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return view('admin.school.exam.edit')->with('exam',$exam);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'template' => 'mimes:docx',

        ]);
        $exam = Exam::findOrFail($id);
        if($request->has('excel')) {
            $exam->update(['excel' => $request->excel]);
        }
        if($request->hasFile('template')){
            if($exam->template){
                \Storage::delete($exam->template);
            }
            $path = $request->file('template')->storePublicly($request->session()->get('slug').'/'.$id);
            $exam->update(['template'=>$path]);
        }
        \Session::flash('message', 'Update Successfully');
        \Session::flash('alert-class', 'bg-green-400');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        foreach (\request()->ids as $id)
        {
            $user = User::where(‘id’,1)->withTrashed()->get();
            $user->delete();
        }
        \Session::flash('message', 'Delete Successfully');
        \Session::flash('alert-class', 'bg-green-400');
        return redirect()->back();
    }
}
