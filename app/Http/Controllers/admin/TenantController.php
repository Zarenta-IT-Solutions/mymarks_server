<?php

namespace App\Http\Controllers\admin;

use App\DataTables\SchoolsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Medium;
use App\Models\Setting;
use App\Models\WebPage;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Notifications\NewSchool;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('datatable')){
            $schools = Tenant::select(['tenants.id','domains.school_name','tenants.created_at'])->join('domains','domains.tenant_id','tenants.id');

            return Datatables::of($schools)
                ->addIndexColumn()
                ->editColumn('created_at', '{{\Carbon\Carbon::parse($created_at)->format("d m y h:i")}}')
                ->make();
        }
        return view('admin.school.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.create');
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
            'id' => 'required|unique:tenants|max:255',
            'school_name' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'name' => 'required',
        ]);

        $tenant = Tenant::create(['id' => $request->id]);
        $tenant->domains()->create(['domain' => $request->id.'.'.config('tenancy.central_domain'),'school_name'=>$request->school_name,'contact_number'=>$request->contact_number]);
        $tenant->run(function ($tenant) use ($request) {
            Artisan::call('db:seed', ['--force' => true ]);
            $user =  User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
            $user->assignRole('admin');
            $user->notify(new NewSchool($request));
            foreach($request->mediums as $k=>$med){
                Medium::firstOrCreate(['name'=>$med,'code'=>$k+1]);
            }
            Setting::firstOrCreate(['title'=>'school_name','val'=>$request->school_name]);
            Setting::firstOrCreate(['title'=>'contact_number','val'=>$request->contact_number]);
            Setting::firstOrCreate(['title'=>'school_email','val'=>$request->email]);
            Setting::firstOrCreate(['title'=>'academic_year_id','val'=>1]);
        });
        flash('Domain Create Successfully')->success();
        return redirect()->route('admin.school.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $domain = Tenant::with('domains')->find($id);
        \request()->session()->put('tenancy_db_name', $domain->tenancy_db_name);
        \request()->session()->put('slug', $id);

       \DB::disconnect('mysql');
       \Config::set('database.connections.mysql.database', $domain->tenancy_db_name);
       \DB::reconnect();
        $users =  User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get();
        $mediums = Medium::get();
//       $users = $domain->run(function ($tenant)  {
//            return User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get();
//        });
//        $mediums = $domain->run(function ($tenant)  {
//          return Medium::get();
//        });

       return view('admin.school.show')->with('domain',$domain)->with('users',$users)->with('mediums',$mediums);
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
        $tenant = Tenant::findOrFail($id);
        $tenant->run(function ($tenant) use ($request) {
            $user = User::find($request->id);
            $user->update(['password'=> Hash::make($request->password)]);
        });
        flash('Password Changed Successfully')->success();
        return redirect()->back();
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
