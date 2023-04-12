<?php

namespace App\Http\Controllers\admin\school;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\request()->has('datatable')){
            $classes = Classes::select(['id','name','created_at']);

            return Datatables::of($classes)
                ->addIndexColumn()
                ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->format("d-m-y h:i")}}')
                ->make();
        }
        return view('admin.school.class.index');
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
        $setting = Setting::where('title','academic_year_id')->firstOrFail();
        $class = Classes::findOrFail($id);
        $exams = Exam::where('class_id',$id)->where('academic_year_id',$setting->val)->paginate();
        return view('admin.school.class.show')->with('class',$class)->with('exams',$exams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::where('title','academic_year_id')->first();
        if($setting){
            $setting->update(['val'=>$id]);
        }else{
            Setting::create(['val'=>$id,'title'=>'academic_year_id']);
        }
        return redirect()->back();
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
