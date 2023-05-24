<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Section::join('classes','classes.id','sections.class_id')
            ->join('users','users.id','sections.teacher_id')
            ->select(['sections.id','sections.name','classes.name as class_name','users.name as teacher','sections.created_at']);
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<a href="#section/edit/'.$user->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
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
        $teachers = User::select('id','name')->role('teacher')->get();
        return response()->json(['classes'=>$classes,'teachers'=>$teachers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'class_id' => 'required',
            'teacher_id' => 'required',
            'name' => 'required',
        ]);
        $data =  $request->only('class_id','teacher_id','name');
        return Section::firstOrCreate($data);

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
        $section = Section::findOrFail($id);
        $classes = Classes::select('name','id')->get();
        $teachers = User::select('id','name')->role('teacher')->get();
        return response()->json(['section'=>$section,'classes'=>$classes,'teachers'=>$teachers]);
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
        $section = Section::findOrFail($id);
        $validator = $request->validate([
            'class_id' => 'required',
            'teacher_id' => 'required',
            'name' => 'required',
        ]);
        $data =  $request->only('class_id','teacher_id','name');
        $section->update($data);
        return response()->json($section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
    }
}
