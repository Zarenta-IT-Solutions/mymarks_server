<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Marks;
use Illuminate\Http\Request;

class SchoolResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::get();
        $sessions = Academic::get();
        return view('thames.aislin.result')->with('title','RESULT')->with('classes',$classes)->with('sessions',$sessions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $mark = Marks::where('academic_year_id',$request->academic_id)->where('exam_id',$request->exam_id)->where('class_id',$request->class_id)->first();
       $keys = array_keys($mark->calculate_data);
       unset($keys['id']);
       return view('thames.aislin.result-show')->with('title','RESULT')->with('mark',$mark)->with('keys',$keys);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exams = Exam::where('class_id',$id)->get();
        foreach($exams as $exam){
            echo "<option value='$exam->id'>$exam->name</option>";
        }
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
