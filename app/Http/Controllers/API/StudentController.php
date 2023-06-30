<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Marks;
use App\Models\Medium;
use App\Models\Classes;
use App\Models\StudentAcademicYear;
use App\Models\Section;
use App\Models\States;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\request()->all){
            return User::role('student')->select('users.*','student_academic_years.academic_id','student_academic_years.fee','cast','media.name as medium','academics.year_range','classes.name as class_name','sections.name as section_name','student_academic_years.roll_number')
            ->join('student_academic_years','student_academic_years.user_id','users.id')
            ->join('academics','academics.id','student_academic_years.academic_id')
            ->leftjoin('media','media.id','users.medium_id')
            ->join('classes','classes.id','student_academic_years.class_id')
            ->leftJoin('sections','sections.id','student_academic_years.section_id')
            ->where('student_academic_years.class_id',\request()->class_id)
            ->where('academic_id',auth()->user()->current_academic_year_id)->get();
        }
        $class = Classes::findOrFail(\request()->class_id);
        $acedemic = Academic::findOrFail(auth()->user()->current_academic_year_id);
        $students = User::role('student')->select('users.id','users.name','users.father_name','users.mother_name','student_academic_years.class_id','student_academic_years.academic_id','users.mobile','users.avatar','users.gender','users.date_of_birth','enrollment','scholar','student_academic_years.fee','cast','users.created_at','media.name as medium','student_academic_years.roll_number')
            ->join('student_academic_years','student_academic_years.user_id','users.id')
            ->leftJoin('media','media.id','users.medium_id')
            ->where('class_id',\request()->class_id)
            ->where('academic_id',auth()->user()->current_academic_year_id);
        return Datatables::of($students)
            ->addIndexColumn()
            ->editColumn('date_of_birth',function ($data){
                if($data->date_of_birth){ return  date("d-m-Y", strtotime($data->date_of_birth)); }
            })
            ->addColumn('action', function ($user) {
                return '<a href="#students/edit/'.$user->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
            })
            ->with('class',$class)
            ->with('academic',$acedemic)
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::all();
        $states = States::where('country_id',101)->get();
        $cities = Cities::where('state_id',21)->get();
        $classes = Classes::select('id','name','fee')->get();
        $mediums = Medium::select('name','id')->get();
        return ['countries'=>$countries,'states'=>$states,'cities'=>$cities,'classes'=>$classes,'mediums'=>$mediums];
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
            'name' => 'required',
            'avatar'=> 'image',
            'medium_id'=> 'required',
        ]);
        $data = $request->only('blood_group','date_of_birth','gender','mobile','name','medium_id','mother_name','father_name','aadhar','cast','family_id','sssm_id','sambal','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account');
        $data['country_id'] = $request->country_id=='null'?NULL:$request->country_id;
        $data['state_id'] = $request->state_id ? NULL: $request->state_id;
        $data['city_id'] = $request->city_id ? NULL : $request->city_id;
        $data['current_academic_year_id'] =  auth()->user()->current_academic_year_id;
        if($request->has('date_of_birth') && $data['date_of_birth']){
            $data['date_of_birth']  = Carbon::parse($data['date_of_birth']);
        }
        if($request->hasFile('image')){
            $data['avatar'] = $request->file('image')->storePublicly('avatars');
        }
        $data['email'] = Str::random(10).'@mymarks.in';
        $data['password'] = Hash::make(Str::random(10));
        $user = User::firstOrCreate($data);
        $user->assignRole('student');
        $data_two['user_id'] = $user->id;
        $data_two['academic_id'] = auth()->user()->current_academic_year_id;
        if($request->has('class_id'))
        {
            $data_two['class_id'] = $request->class_id;
            $data_two['roll_number'] = $request->roll_number;
        }
        StudentAcademicYear::firstOrCreate($data_two);
        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('academicYear')->findOrfail($id);
        $user->dob = Carbon::parse($user->date_of_birth)->format('Y/m/d');
        $countries = Countries::all();
        $states = States::where('country_id',$user->country_id)->get();
        $cities = Cities::where('state_id',$user->state_id)->get();
        $mediums = Medium::select('name','id')->get();
        $classes = Classes::select('id','name','fee')->get();
        if($user->academicYear){
            $sections = Section::select('id','name')->where('class_id',$user->academicYear->class_id)->get();
        }else{
            $sections = Section::select('id','name')->get();
        }
        return response()->json(['user'=>$user,'mediums'=>$mediums,'countries'=>$countries,'states'=>$states,'cities'=>$cities,'classes'=>$classes,'sections'=>$sections],200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('academicYear')->find($id);

        $countries = Countries::all();
        if($user) {
            $states = States::where('country_id', $user->country_id)->get();
            $cities = Cities::where('state_id', $user->state_id)->get();
        }else{
            $states = States::get();
            $cities = Cities::get();
        }
        $mediums = Medium::select('name','id')->get();
        $classes = Classes::select('id','name','fee')->get();

        $sections = Section::select('id','name')->where('class_id',$id)->get();
        // if($sections->isEmpty()){ $sections = [array('name'=>'NA','id'=>0)];  }
        return response()->json(['user'=>$user,'mediums'=>$mediums,'countries'=>$countries,'states'=>$states,'cities'=>$cities,'classes'=>$classes,'sections'=>$sections],200);

    }

    public function section($id)
    {
        $sections = Section::select('id','name')->where('class_id',$id)->get();
        // if($sections->isEmpty()){ $sections = [array('name'=>'NA','id'=>NULL)];}
        return $sections;
    }

    public function image(Request $request,$id)
    {
        $count = 0;

        if($request->hasFile('images')){
            foreach($request->file('images') as $file){
                $ffile = $file->getClientOriginalName();
                $roll_number = pathinfo($ffile,PATHINFO_FILENAME);
                $acedemic = StudentAcademicYear::where('roll_number',$roll_number)->where('academic_id',auth()->user()->current_academic_year_id)->first();
                if($acedemic){
                    $path = $file->storePublicly('avatars');
                    $user = $acedemic->user;
                    $user->avatar = $path;
                    $user->update();
                    $count++;
                }

            }
            return response()->json(['message'=>"$count Files Updated"]);
        }

    }

    public function excelData(Request $request)
    {
        $count = 0;
        foreach($request->data as $data){
            $data_two = [];
            if(isset($data_two['roll_number'])){
                $data_two['roll_number'] = $data['roll_number'];
            }
            if(isset($data['fee'])) {
                $data_two['fee'] = $data['fee'];
            }
            unset($data['roll_number'],$data['fee']);
            $data['email'] = Str::random(10).'@mymarks.in';
            $data['password'] = Hash::make(Str::random(10));
            if(isset($data['date_of_birth']) && Carbon::parse($data['date_of_birth'])){
                $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
            }
            $data['medium_id'] = $request->medium_id;
            $validator = Validator::make($data, [
                'mobile' => 'unique:users|max:255',
            ]);
            if ($validator->fails()) {
                $data['mobile'] = null;
            }
            $user = User::firstOrCreate($data);
            $user->assignRole('student');
            $data_two['user_id'] = $user->id;
            $data_two['academic_id'] = auth()->user()->current_academic_year_id;
            $data_two['class_id'] = $request->class_id;
            $data_two['section_id'] = $request->section_id;
            StudentAcademicYear::firstOrCreate($data_two);
            $count++;

        }
        return response()->json("$count record Added Successfully");
    }

    public function rollNumber(Request $request)
    {
        foreach ($request->students as $student){
            StudentAcademicYear::where('user_id',$student['id'])->where('class_id',$request->class_id)->where('academic_id',auth()->user()->current_academic_year_id)->update(['roll_number'=>$student['roll_number']]);
            $marks = Marks::where('user_id',$student['id'])->where('class_id',$request->class_id)->where('academic_year_id',auth()->user()->current_academic_year_id)->get();
            foreach($marks as $mark) {
                $mark->roll_number = preg_replace("/[^0-9]/", "", $student['roll_number']);
                $markData = $mark->mark_data;
                $markData['roll_number'] = $student['roll_number'];
                $mark->mark_data = $markData;
                $calculate_data = $mark->calculate_data;
                $calculate_data['roll_number'] = $student['roll_number'];
                $mark->calculate_data = $calculate_data;
                $mark->update();
            }

        }
        return response()->json("Roll Number Update Successfully");
    }

    public function promote(Request $request)
    {

        $classes = Classes::select('id','name')->get();
        $academic = Academic::select('id','year','year_range')->get();
        $students = User::role('student')->select('users.id','users.name','users.father_name','student_academic_years.roll_number','student_academic_years.class_id','student_academic_years.academic_id','users.mobile','users.avatar','users.gender','users.date_of_birth','users.created_at','users.deleted_at')
            ->join('student_academic_years','student_academic_years.user_id','users.id')
//            ->join('media','media.id','users.medium_id')
            ->where('class_id',\request()->class_id)
            ->where('academic_id',auth()->user()->current_academic_year_id)->get();
        return response()->json(['classes'=>$classes,'academic'=>$academic,'students'=>$students],200);
    }

    public function promoteUpdate(Request $request)
    {
        $students = User::role('student')->select('users.id','section_id')
            ->join('student_academic_years','student_academic_years.user_id','users.id')
            ->where('class_id',\request()->pramote_by)
            ->where('academic_id',auth()->user()->current_academic_year_id)->get();
        foreach($students as $student){
            StudentAcademicYear::firstOrCreate(['user_id'=>$student->id,'academic_id'=>\request()->academic,'class_id'=>\request()->pramote_to,'section_id'=>$student->section_id]);
        }
        return response()->json(1,200);
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
        $user = User::findOrfail($id);
        $data = $request->only('blood_group','date_of_birth','gender','mobile','name','medium_id','country_id','state_id','city_id','mother_name','father_name','aadhar','cast','address','family_id','sssm_id','sambal','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account');
        $data['country_id'] = $request->country_id=='null'?NULL:$request->country_id;
        $data['state_id'] = $request->state_id ? NULL: $request->state_id;
        $data['city_id'] = $request->city_id ? NULL : $request->city_id;
        if($data['mobile']=='null'){
            unset($data['mobile']);
        }
        if($request->has('date_of_birth') && (bool)strtotime($data['date_of_birth'])){
            $data['date_of_birth']  = Carbon::parse($data['date_of_birth']);
        }else{
            $data['date_of_birth'] = null;
        }
        if($request->hasFile('image')){
             $data['avatar'] = $request->file('image')->storePublicly('avatars');
        }

        $user->update($data);
        if($request->has('class_id'))
        {
            $acedemic = $user->academicYearWithId(auth()->user()->current_academic_year_id);
            $d = $request->only('roll_number','class_id','section_id','fee');
            $d['section_id'] = $d['section_id']=='null'?null:$d['section_id'];
            $acedemic->update($d);

        }
        return response()->json($user,200);
    }


    public function deleteMulti(Request $request)
    {
        foreach($request->all() as $student)
        {
            $user = User::findOrFail($student['id']);
            $user->delete();
        }
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
