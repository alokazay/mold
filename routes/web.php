<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\SearchController;

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

Route::get('/dashboard', function () {
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

    // vacancies
    Route::get('vacancies', [VacancyController::class, 'getIndex']);
    Route::get('vacancy/add', [VacancyController::class, 'getAdd']);
    Route::post('vacancy/add', [VacancyController::class, 'postAdd'])->name('vacancy.add');
    Route::post('files/add', [VacancyController::class, 'filesAdd']);
    Route::post('vacancy/getJson', [VacancyController::class, 'getJson'])->name('vacancy.json');
    Route::get('vacancy/activation', [VacancyController::class, 'vacancyActivation']);



    // ajax search
    Route::get('search/vacancy/client', [SearchController::class, 'getAjaxVacancyClients']);
    Route::get('search/vacancy/industry', [SearchController::class, 'getAjaxVacancyIndustry']);
    Route::get('search/vacancy/nationality', [SearchController::class, 'getAjaxVacancyNationality']);
    Route::get('search/vacancy/workplace', [SearchController::class, 'getAjaxVacancyWorkplace']);
    Route::get('search/vacancy/docs', [SearchController::class, 'getAjaxVacancyDocs']);
});



