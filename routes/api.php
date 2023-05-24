<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('states/{id}', function ($id) { return App\Models\States::where('country_id',$id)->get(); });
Route::get('cities/{id}', function ($id) { return App\Models\Cities::where('state_id',$id)->get(); });

Route::post('super/login', [\App\Http\Controllers\Auth\ApiAuthController::class,'super']);
Route::post('login', [\App\Http\Controllers\Auth\ApiAuthController::class,'login']);
Route::post('teacher/login', [\App\Http\Controllers\Auth\ApiAuthController::class,'teacher_login']);
Route::post('account/login', [\App\Http\Controllers\Auth\ApiAuthController::class,'accountant_login']);
Route::post('parent/login', [\App\Http\Controllers\Auth\ApiAuthController::class,'parent_login']);
Route::post('student/login', [\App\Http\Controllers\Auth\ApiAuthController::class,'student_login']);


Route::group(['middleware' => ['auth:sanctum'],'prefix'=>'super'], function () {
    Route::get('classes-list', [\App\Http\Controllers\API\SUPER\ClassController::class,'index']);
    Route::get('exams-data/{id}', [\App\Http\Controllers\API\SUPER\ClassController::class,'exams']);
    Route::get('exams-list/{id}', [\App\Http\Controllers\API\SUPER\ClassController::class,'exams_list']);
    Route::post('exams-upload/{eid}', [\App\Http\Controllers\API\SUPER\ClassController::class,'exams_upload']);
    Route::get('exam-marks/{eid}', [\App\Http\Controllers\API\SUPER\ClassController::class,'exam_marks']);
    Route::get('exam-calculate-marks/{eid}', [\App\Http\Controllers\API\SUPER\ClassController::class,'exam_calculated_marks']);
});

Route::group(['middleware' => ['auth:sanctum'],'namespace'=>'\App\Http\Controllers\API','as'=>'api.'], function () {
    Route::post('logout', [\App\Http\Controllers\Auth\ApiAuthController::class,'logout']);
    Route::post('session/list', [\App\Http\Controllers\API\AcedemicYearController::class,'index']);
    Route::get('session/show', [\App\Http\Controllers\API\AcedemicYearController::class,'create']);
    Route::get('session/set/{id}', [\App\Http\Controllers\API\AcedemicYearController::class,'set']);
    Route::resource('session', AcedemicYearController::class);
    Route::post('user-list', [\App\Http\Controllers\API\UserController::class,'index']);
    Route::resource('user', UserController::class);
    Route::post('class/types/list', [\App\Http\Controllers\API\ClassTypeController::class,'index']);
    Route::get('classes/all', [\App\Http\Controllers\API\ClassController::class,'listClass']);
    Route::resource('class/types', ClassTypeController::class);

    Route::post('classes/excel', [\App\Http\Controllers\API\ClassController::class,'excel']);
    Route::post('classes/list', [\App\Http\Controllers\API\ClassController::class,'index']);
    Route::resource('classes', ClassController::class);
    Route::post('section/list', [\App\Http\Controllers\API\SectionController::class,'index']);
    Route::resource('section', SectionController::class);
    Route::post('subject/list', [\App\Http\Controllers\API\SubjectController::class,'index']);
    Route::resource('subject', SubjectController::class);
    Route::get('exam/subject/{id}', [\App\Http\Controllers\API\ExamController::class,'subject']);
    Route::post('exam/list', [\App\Http\Controllers\API\ExamController::class,'index']);
    Route::resource('exam', ExamController::class);
    Route::get('student/sections/{id}', [\App\Http\Controllers\API\StudentController::class,'section']);
    Route::get('student/promote', [\App\Http\Controllers\API\StudentController::class,'promote']);
    Route::post('student/promote', [\App\Http\Controllers\API\StudentController::class,'promoteUpdate']);
    Route::post('student/delete', [\App\Http\Controllers\API\StudentController::class,'deleteMulti']);
    Route::post('student/image/{id}', [\App\Http\Controllers\API\StudentController::class,'image']);
    Route::post('student/list', [\App\Http\Controllers\API\StudentController::class,'index']);
    Route::post('student/excel', [\App\Http\Controllers\API\StudentController::class,'excelData']);
    Route::post('student/roll-number', [\App\Http\Controllers\API\StudentController::class,'rollNumber']);
    Route::resource('student', StudentController::class);
    Route::post('mark/upload-doc', [\App\Http\Controllers\API\MarksController::class,'uploadDocFile']);
    Route::resource('mark', MarksController::class);
    Route::resource('events', EventsController::class);
});

Route::group(['middleware' => ['auth:sanctum','role:teacher'],'prefix'=>'teacher','as'=>'teacher.','namespace'=>'\App\Http\Controllers\API\TEACHER'], function () {
  Route::resource('events', EventsController::class);
  Route::resource('timetable', TimeTableController::class);
  Route::resource('student', StudentController::class);
  Route::resource('mark', MarksController::class);
});

Route::group(['middleware' => ['auth:sanctum','role:account'],'prefix'=>'account','as'=>'account.','namespace'=>'\App\Http\Controllers\API\ACCOUNT'], function () {
  Route::resource('events', EventsController::class);
});

Route::group(['middleware' => ['auth:sanctum','role:parent'],'prefix'=>'parent','as'=>'parent.','namespace'=>'\App\Http\Controllers\API\PARENT'], function () {
  Route::resource('events', EventsController::class);
});

Route::group(['middleware' => ['auth:sanctum','role:student'],'prefix'=>'student','as'=>'student.','namespace'=>'\App\Http\Controllers\API\STUDENT'], function () {
  Route::resource('events', EventsController::class);
});
