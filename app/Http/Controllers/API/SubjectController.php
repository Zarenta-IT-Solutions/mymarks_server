<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Subject::join('classes','classes.id','subjects.class_id')
            ->join('users','users.id','subjects.teacher_id')
            ->select(['subjects.id','subjects.name','subjects.code','subjects.min','subjects.max','classes.name as class_name','users.name as teacher','subjects.s_type','subjects.created_at']);
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<a href="#subject/edit/'.$user->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
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
            'code' => 'required',
        ]);
        $data =  $request->only('class_id','teacher_id','name','code','s_type','min','max');
        $data['slug'] = Str::slug($request->name,'_');
        return Subject::firstOrCreate($data);
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
        $subject = Subject::findOrFail($id);
        $classes = Classes::select('name','id')->get();
        $teachers = User::select('id','name')->role('teacher')->get();
        return response()->json(['subject'=>$subject,'classes'=>$classes,'teachers'=>$teachers]);
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
        $subject = Subject::findOrFail($id);
        $request->validate(['class_id' => 'required','teacher_id' => 'required','name' => 'required','code' => 'required']);
        $data =  $request->only('class_id','teacher_id','name','code','s_type','min','max');
        $subject->update($data);
        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        return $subject->delete();
    }
}
