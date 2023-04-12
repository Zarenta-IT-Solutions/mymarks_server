<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassType;
use Illuminate\Http\Request;
use DataTables;

class ClassTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ClassType::select(['id','name','code','created_at']);
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<a href="#class-type/edit/'.$user->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                        <a  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
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
            'name' => 'required',
            'code' => 'required',
        ]);
        $data = $request->only('name','code');
        return ClassType::firstorCreate($data);
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
        return ClassType::findOrFail($id);
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
            'name' => 'required',
            'code' => 'required',
        ]);
        $data = $request->only('name','code');
        $type = ClassType::findOrFail($id);
        return $type->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = ClassType::findOrFail($id);
        return $type->delete();
    }
}
