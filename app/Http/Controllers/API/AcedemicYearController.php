<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class AcedemicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academics = Academic::select(['id','year','year_range','selected','created_at']);
        return Datatables::of($academics)
            ->addIndexColumn()
            ->addColumn('action', function ($academic) {
                return '<a href="#session/edit/'.$academic->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                        <a [(click)]="Default('.$academic->id.')" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
                        <a (click)="delete('.$academic->id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
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
        $sessons = Academic::select('id','year','year_range')->get();
        $sesson = Academic::where('id',auth()->user()->current_academic_year_id)->first();
        return response(['sessions'=>$sessons,'session'=>$sesson],200);
    }

    public function set($id)
    {
        $user = auth()->user();
        $user->current_academic_year_id = $id;
        $user->update();
        return response(1,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'year_range' => 'required'
        ]);
        $data = $request->only('year','year_range');
        return Academic::firstorCreate($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $academic = Academic::findOrFail($id);
        $academic->selected = $academic->selected=='YES'?'NO':'YES';
        $academic->update();
        return $academic;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Academic::findOrFail($id);
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
        $academic = Academic::findOrFail($id);
        $request->validate([
            'year' => 'required',
            'year_range' => 'required'
        ]);
        $data = $request->only('year','year_range');
        $academic->update($data);
        return $academic;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $academic = Academic::findOrFail($id);
        return $academic->delete();
    }
}
