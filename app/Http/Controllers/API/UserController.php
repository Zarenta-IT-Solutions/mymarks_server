<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\User;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::join('model_has_roles','model_has_roles.model_id','users.id')
                    ->join('roles','roles.id','model_has_roles.role_id')
            ->select(['users.id','users.name','users.avatar','users.email','users.mobile','users.gender','roles.name as role_name']);
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<a href="#user/edit/'.$user->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
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
        $roles = Role::where('name','!=','student')->get();
        $countries = Countries::all();
        $states = States::where('country_id',101)->get();
        $cities = Cities::where('state_id',21)->get();
        return ['roles'=>$roles,'countries'=>$countries,'states'=>$states,'cities'=>$cities];
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
            'email' => 'required|unique:users|max:255',
            'password' => 'min:8|required',
            'name' => 'required',
        ]);
        $data =  $request->except('image','role_id');
        if($request->hasFile('image')){
            $data['avatar'] = $request->file('image')->storePublicly('avatars');
        }
        $data['password']  = Hash::make($data['password']);

        $data['current_academic_year_id'] = auth()->user()->current_academic_year_id;
        $user = User::firstOrCreate($data);
        $user->assignRole($request->role_id);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return $user = User::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $user->role = $user->roles->pluck('name');
        $roles = Role::all();
        $countries = Countries::all();
        $states = States::where('country_id',$user->country_id)->get();
        $cities = Cities::where('state_id',$user->state_id)->get();
        return ['user'=>$user,'roles'=>$roles,'countries'=>$countries,'states'=>$states,'cities'=>$cities];
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
        $user = User::findOrFail($id);
        $data =  $request->except('image','password','_method');

        if($request->hasFile('image')){
            $data['avatar'] = $request->file('image')->storePublicly('avatars');
        }
        $user->update($data);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }
}
