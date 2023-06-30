<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\User;
use App\Models\Marks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Terbilang;
use DataTables;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Exam::where('academic_year_id',auth()->user()->current_academic_year_id)
            ->join('classes','classes.id','exams.class_id')
            ->select(['exams.id','exams.name','classes.name as class_name','exams.created_at']);
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<a href="#exam/edit/'.$user->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::select('name','id')->get();
        return response()->json(['classes'=>$classes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['class_id' => 'required','name' => 'required']);
        $data =  $request->only('class_id','name','subject_data');
        $data['academic_year_id'] = auth()->user()->current_academic_year_id;
       return Exam::firstOrCreate($data);
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
    public function subject($id)
    {
        return Subject::where('class_id',$id)->select('id','name','min','max','slug','s_type')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classes = Classes::select('name','id')->get();
        $exam = Exam::findorfail($id);
        $subjects = Subject::where('class_id',$exam->class_id)->select('id','name','min','max','slug','s_type')->get();
        $marks = Marks::where('class_id',$exam->class_id)->where('exam_id',$exam->id)->where('academic_year_id',auth()->user()->current_academic_year_id)->get();
        return response()->json(['classes'=>$classes,'exam'=>$exam,'marks'=>$marks, 'subjects'=>$subjects]);
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
        $exam = Exam::findorfail($id);
        $request->validate([
            'subject_data' => 'required',
            'name' => 'required',
        ]);
        $data =  $request->only('name','subject_data');
        return $exam->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findorfail($id);
        return $exam->delete();
    }
}
