<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\StudentAcademicYear;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Exam;
use App\Models\Section;
use App\Models\Marks;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkStudent($exam_id, $classId)
    {
        $deletedUsers = User::where('student_academic_years.class_id',$classId)
            ->join('student_academic_years','users.id','student_academic_years.user_id')
            ->where('student_academic_years.academic_id',auth()->user()->current_academic_year_id)->onlyTrashed()->get();

        if($deletedUsers) {
            foreach ($deletedUsers as $delUser) {
                $mark = Marks::where('class_id', $classId)->where('user_id', $delUser->user_id)->where('exam_id', $exam_id)->where('academic_year_id', auth()->user()->current_academic_year_id)->delete();
            }
        }
        $users = User::select('users.id','users.name','student_academic_years.roll_number','users.deleted_at')
            ->join('student_academic_years','users.id','student_academic_years.user_id')
            ->where('student_academic_years.class_id',$classId)
            ->where('academic_id',auth()->user()->current_academic_year_id)->get()->toArray();
        $subjects = Subject::select('name','code','slug')->where('class_id',$classId)->get();
        foreach($users as $key=>$user){
            $mark = Marks::where('class_id',$classId)->where('user_id',$user['id'])->where('exam_id',$exam_id)->where('academic_year_id',auth()->user()->current_academic_year_id)->count();
            if(!$mark) {
                foreach ($subjects as $subject) {
                    $user[$subject->slug] = 0;
                }
                Marks::firstOrCreate([
                    'class_id' => $classId,
                    'academic_year_id' => auth()->user()->current_academic_year_id,
                    'exam_id' => $exam_id,
                    'user_id' => $user['id'],
                    'roll_number' =>preg_replace("/[^0-9]/", "", $user['roll_number']),
                    'mark_data' => $user
                ]);
            }
        }
    }


    public function create(Request $request)
    {
        if($request->has('exam'))
        {
            $exams = Exam::where('class_id',$request->class_id)->where('academic_year_id',auth()->user()->current_academic_year_id)->select('id','name','subject_data')->get();
            $sections = Section::where('class_id',$request->class_id)->select('id','name')->get();
            return response()->json(['exams'=>$exams,'sections'=>$sections],200);
        }
        if($request->has('students')) {
            $this->checkStudent($request->exam_id, $request->class_id);
            $exam = Exam::where('id',$request->exam_id)->select('id','name','subject_data')->first();
            $marks = Marks::where('class_id',$request->class_id)
                ->where('exam_id',$request->exam_id)->where('academic_year_id',auth()->user()->current_academic_year_id)->orderBy('roll_number')->pluck('mark_data');
            $class = Classes::find($request->class_id);
            return response()->json(['marks'=>$marks,'exam'=>$exam,'class'=>$class],200);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->has('all')){
            $exam = Exam::findOrFail($id);
            $marks = Marks::where('academic_year_id',auth()->user()->current_academic_year_id)->where('exam_id',$exam->id)->where('class_id',$exam->class_id)->get();
            $temDirectory = 'temp/';
            if (!file_exists($temDirectory)) {
                mkdir($temDirectory, 0777, true);
            }
            $files = array();
            foreach($marks as $k=>$mark){
                $user = User::where('id',$mark->user_id)->select('name','email','password','address','mobile','date_of_birth','current_academic_year_id','gender','about','avatar','address','blood_group','mother_name','father_name','aadhar','cast','family_id','sssm_id','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account','sambal')->first();
                if($user) {
                    $acedmic = StudentAcademicYear::where('user_id',$mark->user_id)->where('academic_id', auth()->user()->current_academic_year_id)->first();
                    $data = array_merge($mark->user->toArray(), array('roll_number' => $acedmic->roll_number,'medium'=>ucfirst($mark->user->medium->name),'dobw'=>DOBinWord($mark->user->date_of_birth),'session'=>$acedmic->academic->year_range,'class_name'=>$exam->my_class->name), $mark->calculate_data);
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Storage::url('../'.$exam->template));
                    if($user['avatar']!=null && Storage::get($user['avatar'])) {
                        $templateProcessor->setImageValue('avatar', array('src' => $user['avatar'], 'height' => '150', 'width' => '150'));
                    }
                    $data['avatar']='';
                    $templateProcessor->setValues($data);
                    $templateProcessor->saveAs($temDirectory . $acedmic->roll_number . '.docx');
                    array_push($files,$temDirectory . $acedmic->roll_number . '.docx');
                }
            }
            $dm = new DocxMerge();
            $dm->merge($files,'result.docx');
            \File::deleteDirectory(public_path($temDirectory));
            return response()->download('result.docx')->deleteFileAfterSend(true);
        }else {
            $exam = Exam::findOrFail($id);
            $mark = Marks::where('user_id', $request->student)->where('exam_id', $id)->where('academic_year_id', auth()->user()->current_academic_year_id)->first();
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Storage::url('../'.$exam->template));

            $acedmic = StudentAcademicYear::where('user_id',$mark->user_id)->where('academic_id', auth()->user()->current_academic_year_id)->first();
            $data = array_merge($mark->user->toArray(), array('roll_number' => $acedmic->roll_number,'medium'=>ucfirst($mark->user->medium->name),'dobw'=>DOBinWord($mark->user->date_of_birth),'session'=>$acedmic->academic->year_range,'class_name'=>$exam->my_class->name), $mark->calculate_data);
//            dd($data);
            if($data['avatar']!=null) {
                $templateProcessor->setImageValue('avatar', array('src' => $data['avatar'], 'height' => '250', 'width' => '250'));
            }
            $data['avatar']='';
            $templateProcessor->setValues($data);
            $templateProcessor->saveAs('temp.docx');
            return response()->download('temp.docx')->deleteFileAfterSend(true);
        }
    }

    public function uploadDocFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5000|mimes:docx,doc',
        ]);
        $exam = Exam::where('class_id',$request->class_id)->where('academic_year_id',auth()->user()->current_academic_year_id)->firstOrFail();
        if($request->hasFile('file')){
            Storage::delete($exam->template);
           $exam->template= $request->file('file')->storePublicly('templates');
        }
        $exam->update();
        return response()->json(['message'=>'File Upload Successfully'],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = $request->validate([
            'exam_id' => 'required',
            'students' => 'required',
        ]);
        foreach($request->students as $student)
        {
            $mark = Marks::where('user_id',(int)$student['id'])->where('class_id',$id)->where('exam_id',$request->exam_id)->where('academic_year_id',auth()->user()->current_academic_year_id)->first();
            if($mark){
              $mark->update(['mark_data'=>$student]);
            }
        }
        return response()->json('success',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
