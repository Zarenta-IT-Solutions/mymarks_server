<?php

namespace App\Http\Controllers\API\SUPER;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Marks;
use App\Models\StudentAcademicYear;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Classes;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MarksImport;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Classes::select(DB::raw('CONCAT(id, \' - \',name) AS NAME'))->pluck('NAME');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exams($id)
    {
        $exams = Exam::where('academic_year_id',auth()->user()->current_academic_year_id)->select('name','id')->where('class_id',$id)->get();
        foreach($exams as $k=>$exam)
        {
            $exams[$k]->slug = \Str::slug($exam->name);
            $exams[$k]->marks = Marks::where('exam_id',$exam->id)->where('academic_year_id',auth()->user()->current_academic_year_id)->pluck('mark_data');
        }
        return response()->json($exams, 200);
    }


    public function exams_list($id)
    {
        $exams = Exam::where('academic_year_id',auth()->user()->current_academic_year_id)->select(DB::raw('CONCAT(id, \' - \',name) AS NAME'))->where('class_id',$id)->pluck('NAME');
        return response()->json($exams, 200);
    }
    
    public function exam_marks($id)
    {
        $marks = Marks::where('exam_id',$id)->where('academic_year_id',auth()->user()->current_academic_year_id)->pluck('mark_data');
        return response()->json($marks, 200);
    }

    public function exam_calculated_marks($id)
    {
        $marks = Marks::where('exam_id',$id)->where('academic_year_id',auth()->user()->current_academic_year_id)->pluck('calculate_data');
        foreach($marks as $k=>$mark){
            $user = User::where('id',$mark['id'])->select('name','email','password','address','mobile','date_of_birth','current_academic_year_id','gender','about','avatar','address','blood_group','mother_name','father_name','aadhar','cast','family_id','sssm_id','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account','sambal')->first()->toArray();
            $acedmic = StudentAcademicYear::where('user_id',$mark['id'])->where('academic_id',1)->first();
            $marks[$k] = array_merge($user,array('roll_number'=>$acedmic->roll_number),$marks[$k]);
        }
        return response()->json($marks, 200);
    }

    public function exams_upload(Request $request,  $eid)
    {
        $marks = json_decode($request->data);
        if(is_array($marks) or is_object($marks)){
            foreach($marks as $mark){
                $mar = Marks::where('exam_id',$eid)->where('academic_year_id',auth()->user()->current_academic_year_id)->where('user_id',$mark->id)->first();
                $mar->update(['calculate_data'=>$mark]);
            }
            return response()->json('Date Update Successfully');
        }
        return response()->json('Data Not Uploaded');

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
    public function show($id)
    {
        //
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
        //
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
