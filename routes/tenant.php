<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class,'school'])->name('school.welcome');
    Route::resource('result', \App\Http\Controllers\SchoolResultController::class);
    Route::get('about', [\App\Http\Controllers\HomeController::class,'school_page'])->name('school.page');
    Route::get('contact', [\App\Http\Controllers\HomeController::class,'school_contact'])->name('school.contact');
    Route::get('blog', [\App\Http\Controllers\HomeController::class,'school_blog'])->name('school.blog');
    Route::get('blog/{slug}', [\App\Http\Controllers\HomeController::class,'school_blog_single'])->name('school.blog.single');
    Route::group(['middleware' => ['role:admin'],'prefix'=>'admin','as'=>'admin.'], function () {
        Route::get('dashboard', [\App\Http\Controllers\admin\DashboardController::class,'admin'])->name('dashboard');
//        Route::resource('school',\App\Http\Controllers\admin\TenantController::class);
//        Route::get('users/excel',[\App\Http\Controllers\admin\UsersController::class,'excel']);
//        Route::resource('users',\App\Http\Controllers\admin\UsersController::class);
//        Route::get('mark/{id}',[\App\Http\Controllers\API\MarksController::class,'show']);
    });

});


