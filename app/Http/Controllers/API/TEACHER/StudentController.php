<?php

namespace App\Http\Controllers\API\TEACHER;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = User::role('student')->select('users.id','users.name','users.mobile','users.avatar','users.email','users.gender','users.created_at')
                    ->join('student_academic_years','student_academic_years.user_id','users.id')
                    ->where('class_id',\request()->classId)->where('academic_id',auth()->user()->current_academic_year_id);
        if(\request()->has('search') && \request()->search!='null' && \request()->search!=null){
            $query->where('name','like','%'.\request()->search.'%');
            $query->orWhere('email','like','%'.\request()->search.'%');
        }
        $students = $query->latest()->paginate(\request()->perPage);
        return response()->json($students, 200);
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
