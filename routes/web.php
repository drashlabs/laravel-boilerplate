<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\studentController;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified']);
Route::get('/home', 'studentController@index')->name('home')->middleware(['auth', 'verified']);
Route::delete('/home/{id}', 'studentController@destory')->name('remove')->middleware(['auth', 'verified']);
Route::post('student/registerstudent', 'studentController@store')->name('student.register')->middleware(['auth', 'verified']);

Auth::routes([
    'verify' => true,
]);
Route::post('student/registerstudent', [\App\Http\Controllers\studentController::class, 'store'])->name('student.register')->middleware(['auth', 'verified']);
Route::get('/home', [\App\Http\Controllers\studentController::class, 'index'])->name('home')->middleware(['auth', 'verified']);
Route::delete('/home/{id}', [\App\Http\Controllers\studentController::class, 'destroy'])->name('remove')->middleware(['auth', 'verified']);
Route::match(['get', 'put'], '/users/{token}/welcome', [\App\Http\Controllers\Auth\WelcomeController::class, 'setPassword'])->name('users.welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::resource('users', UserController::class)->except('show', 'edit', 'update');
});

Route::resource('users', UserController::class)->only('show', 'edit', 'update')->middleware('auth');

Route::namespace('App\Http\Controllers\Admin')->middleware(['auth', 'verified'])->name('admin.')->prefix('setup/')->group(function () {
    Route::get('/roles/{role}/delete', [RoleController::class, 'delete'])->name('roles.delete');
    Route::resource('roles', RoleController::class);

    Route::resource('permissionGroups', PermissionGroupController::class)->except('index', 'show', 'destroy');

    Route::get('/permissions/{permission}/delete', [PermissionController::class, 'delete'])->name('permissions.delete');
    Route::resource('permissions', PermissionController::class);

    Route::get('/audits', 'AuditController@auditing')->name('auditing.index');
});
