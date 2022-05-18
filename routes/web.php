<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

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

Route::get('/', [AuthController::class, 'getMain'])->middleware('auth');

Route::get('/dashboard', function (){
    if (Auth::user()->group_id == 1) {
        return Redirect::to('users');
    }
})->middleware('auth');

Route::get('login', [AuthController::class, 'getLogin'])->name("login");
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('logout', [AuthController::class, 'getLogout']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('users', [UsersController::class, 'getIndex']);
    Route::post('users/getJson', [UsersController::class, 'getJson'])->name('users.json');
    Route::post('users/add', [UsersController::class, 'addUser'])->name('users.add');
    Route::post('/files/user/add', [UsersController::class, 'filesUserAdd']);
    Route::get('/users/ajax/id/{id}', [UsersController::class, 'getUserAjax'])->name('users.ajax.id');
    Route::get('/users/activation', [UsersController::class, 'usersActivation']);
    Route::get('/users/auth_by/{id}', [UsersController::class, 'authBy'])->middleware('is_admin');

});



