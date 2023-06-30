<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class,'index']);
Route::get('token', [\App\Http\Controllers\HomeController::class,'token']);
Route::get('excel', [\App\Http\Controllers\HomeController::class,'excel']);
Route::get('whatspp', [\App\Http\Controllers\HomeController::class,'whatspp']);
Route::get('sitemap.xml', [\App\Http\Controllers\HomeController::class,'sitemap']);
Route::get('admin', [\App\Http\Controllers\HomeController::class,'admin']);




Route::get('check-school/{name}', [\App\Http\Controllers\HomeController::class,'checkSchool']);

//Route::get('/', [\App\Http\Controllers\HomeController::class,'index'])->name('home');

Route::group(['middleware' => ['auth','role:admin','SubDomain'],'prefix'=>'school','as'=>'school.'], function () {
    Route::get('dashboard', [\App\Http\Controllers\admin\DashboardController::class,'school_dashboard'])->name('dashboard');
    Route::get('migrate', [\App\Http\Controllers\admin\DashboardController::class,'school_migration']);
    Route::resource('users',\App\Http\Controllers\admin\school\UsersController::class);
    Route::resource('files',\App\Http\Controllers\admin\school\FileController::class);
    Route::resource('class',\App\Http\Controllers\admin\school\ClassController::class);
    Route::get('exam/roll/{id}',[\App\Http\Controllers\admin\school\ExamController::class,'rollPrint'])->name('exam.roll');
    Route::resource('exam',\App\Http\Controllers\admin\school\ExamController::class);
});

Route::group(['middleware' => ['role:admin'],'prefix'=>'admin','as'=>'admin.'], function () {
    Route::get('dashboard', [\App\Http\Controllers\admin\DashboardController::class,'admin'])->name('dashboard');
    Route::resource('school/{id}/pages',\App\Http\Controllers\admin\PageController::class);
    Route::resource('school',\App\Http\Controllers\admin\TenantController::class);
    Route::get('users/excel',[\App\Http\Controllers\admin\UsersController::class,'excel']);
    Route::resource('users',\App\Http\Controllers\admin\UsersController::class);
});

require __DIR__.'/auth.php';
