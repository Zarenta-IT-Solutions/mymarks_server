<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\ClassType;
use App\Models\Classes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::select(['classes.id','classes.name','class_types.name as type_name','classes.created_at'])
            ->join('class_types','classes.class_type_id','class_types.id');
        return Datatables::of($classes)
            ->addIndexColumn()
            ->addColumn('action', function ($class) {
                return '<a href="#classes/edit/'.$class->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                        <a [click]="DElete()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
            })
            ->make(true);
    }

    public function listClass()
    {
        $classes = Classes::pluck('name');
        $arrays = [];
        foreach ($classes as $class){
            array_push($arrays,['path'=>\Str::slug($class),'title'=>ucfirst($class)]);
        }
        return $arrays;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return ClassType::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name','class_type_id','fee');
        return Classes::firstOrCreate($data);
    }
    public function excel(Request $request)
    {
        if($request->hasFile('file')){
            try {
            $excel = Excel::import(new UsersImport($request->class_id,$request->section_id,auth()->user()->current_academic_year_id), $request->file('file'));
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                dd($failures);
            }
        }
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
        $class = Classes::findOrFail($id);
        $types = ClassType::get();
        return ['class'=>$class,'types'=>$types];
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
        $class = Classes::findOrFail($id);
        $data = $request->only('name','class_type_id','fee');
        return $class->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        return $class->delete();
    }
}
