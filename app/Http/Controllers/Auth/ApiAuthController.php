<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Classes;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{


    public function super(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...
            $user = auth()->user();
            $user->api_token = $user->createToken('patrak')->plainTextToken;
            return $user->only('api_token','name','avatar','id');
        }

        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }

    public function login (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if (!$validator->fails())
        {
            if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                // Authentication passed...
                $user = auth()->user();
                if(!$user->current_academic_year_id){
                    $ac = Academic::where('selected','yes')->first();
                    if($ac) {
                        $user->current_academic_year_id = $ac->id;
                    }
                    $user->update();
                }
                $tenant = tenancy()->tenant->domains->first();
                $user->school_name =  $tenant->school_name;
                $user->classes = Classes::select(DB::raw('CONCAT("students/", id) AS path'),'name as title')->get();
                $user->api_token = $user->createToken('rajesh')->plainTextToken;
                return $user->only('api_token','classes','name','avatar','current_academic_year_id','id','school_name');
            }
        }
        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }

    public function teacher_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...
            $user = auth()->user();
            if($user->hasRole('teacher')) {
                if($user->current_academic_year_id){
                    $user->academic = Academic::find($user->current_academic_year_id);
                }else {
                    $academic =Academic::where('selected','YES')->first();
                    $user->current_academic_year_id = $academic->id;
                    $user->update();
                    $user->academic = $academic;
                }
                $user->api_token = $user->createToken('patrak')->plainTextToken;
                $user->role = $user->getRoleNames();
                $user->classes = Classes::select(DB::raw('CONCAT("students/", id) AS path'),'name as title')->get();
                return response()->json($user->only('classes','academic','api_token','name','avatar','id'),200);
            }else{
                $this->logout();
                return response()->json([
                    'error' => 'Unauthenticated user',
                    'code' => 401,
                ], 401);
            }
        }

        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }

    public function accountant_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...
            $user = auth()->user();
            if($user->hasRole('accountant')) {
                $user->api_token = $user->createToken('patrak')->plainTextToken;
                $user->role = $user->getRoleNames();
                $user->academic = Academic::where('selected', 1)->first();
                return $user;
            }else{
                $this->logout();
                return response()->json([
                    'error' => 'Unauthenticated user',
                    'code' => 401,
                ], 401);
            }
        }

        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }

    public function parent_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...
            $user = auth()->user();
            if($user->hasRole('parent')) {
                $user->api_token = $user->createToken('patrak')->plainTextToken;
                $user->role = $user->getRoleNames();
                $user->academic = Academic::where('selected', 1)->first();
                return $user;
            }else{
                $this->logout();
                return response()->json([
                    'error' => 'Unauthenticated user',
                    'code' => 401,
                ], 401);
            }
        }

        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }

    public function student_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...
            $user = auth()->user();
            if($user->hasRole('student')) {
                $user->api_token = $user->createToken('patrak')->plainTextToken;
                $user->role = $user->getRoleNames();
                $user->academic = Academic::where('selected', 1)->first();
                return $user;
            }else{
                $this->logout();
                return response()->json([
                    'error' => 'Unauthenticated user',
                    'code' => 401,
                ], 401);
            }
        }

        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }

    public function logout (Request $request)
    {
        $user = auth()->user();
        if($user->tokens()->delete()) {
            return response()->json(['message' => 'User successfully signed out'],200);
        }else {
            return response()->json(['message' => 'User Not signed out'],401);
                }
    }

}
