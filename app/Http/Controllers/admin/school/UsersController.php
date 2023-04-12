<?php

namespace App\Http\Controllers\admin\school;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Imports\UsersImport;
use App\Notifications\NewUser;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('datatable')){
            $users = User::role('admin')->select(['id','name','email','created_at']);

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('role',function ($user){ return $user->getRoleNames(); })
                ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->format("d-m-y h:i")}}')
                ->make();
        }
        return view('admin.school.users.index');
    }
    public function excel()
    {
        $excel = Excel::import(new UsersImport, public_path('student-sample.xlsx'));
        return 'success';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'email' => 'required|unique:users|max:255',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'name' => 'required',
        ]);
        $data = $request->except('_token','password_confirmation');
        $data['password'] = Hash::make($data['password']);
        $user = User::firstOrCreate($data);
        $user->sendEmailVerificationNotification();
        $user->notify(new NewUser($request));
        $user->assignRole('admin');
        flash('User Create Successfully')->success();
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('academicYear')->findOrFail($id);
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
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.school.users.edit')->with('user',$user)->with('roles',$roles);
  
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
        $user = User::findorFail($id);
        $validator = $request->validate([
            'email' => 'required|max:255|unique:users,email,'.$id,
            'password' => 'min:8|same:password_confirmation',
            'name' => 'required',
        ]);
        $data = $request->except('_token','password_confirmation');
        if($request->has('password')){
            $data['password'] = Hash::make($data['password']);
        }
        if($request->has('roles')){
            $user->syncRoles($request->roles);
        }
        $user->update($data);
        flash('User Update Successfully')->success();
        return redirect()->route('school.users.index');
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
