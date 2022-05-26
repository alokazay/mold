<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FreelancersController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\HandbookController;

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

    // freelancers
    Route::get('freelancers', [FreelancersController::class, 'getIndex']);
    Route::post('freelancers/getJson', [FreelancersController::class, 'getJson'])->name('freelancers.json');
    Route::get('freelancers/set_fl_status', [FreelancersController::class, 'setFlStatus']);

    // clients
    Route::get('clients', [ClientController::class, 'getIndex']);
    Route::post('clients/getJson', [ClientController::class, 'getJson'])->name('clients.json');
    Route::get('clients/activation', [ClientController::class, 'clientsActivation']);
    Route::get('client/add', [ClientController::class, 'getAdd']);
    Route::post('client/add', [ClientController::class, 'postAdd'])->name('clients.add');


    // vacancies
    Route::get('vacancies', [VacancyController::class, 'getIndex']);
    Route::get('vacancy/add', [VacancyController::class, 'getAdd']);
    Route::post('vacancy/add', [VacancyController::class, 'postAdd'])->name('vacancy.add');
    Route::post('files/add', [VacancyController::class, 'filesAdd']);
    Route::post('vacancy/getJson', [VacancyController::class, 'getJson'])->name('vacancy.json');
    Route::get('vacancy/activation', [VacancyController::class, 'vacancyActivation']);
    Route::get('vacancy/changecost', [VacancyController::class, 'vacancyChangecost']);


    // candidates
    Route::get('candidates', [CandidateController::class, 'getIndex']);
    Route::post('candidates/getJson', [CandidateController::class, 'getJson'])->name('candidates.json');
    Route::get('candidate/set_status', [CandidateController::class, 'setFlStatus']);

    // handbooks
    Route::get('handbooks', [HandbookController::class, 'getIndex']);
    Route::get('handbooks/delete', [HandbookController::class, 'deleteHandbook']);
    Route::get('handbooks/add', [HandbookController::class, 'addHandbook']);



    // ajax search
    Route::get('search/vacancy/client', [SearchController::class, 'getAjaxVacancyClients']);
    Route::get('search/vacancy/industry', [SearchController::class, 'getAjaxVacancyIndustry']);
    Route::get('search/vacancy/nationality', [SearchController::class, 'getAjaxVacancyNationality']);
    Route::get('search/vacancy/workplace', [SearchController::class, 'getAjaxVacancyWorkplace']);
    Route::get('search/vacancy/docs', [SearchController::class, 'getAjaxVacancyDocs']);

    Route::get('search/client/industry', [SearchController::class, 'getAjaxClientIndustry']);
    Route::get('search/client/workplace', [SearchController::class, 'getAjaxClientWorkplace']);
    Route::get('search/client/coordinator', [SearchController::class, 'getAjaxClientCoordinator']);

    Route::get('search/candidate/vacancy', [SearchController::class, 'getAjaxCandidateVacancy']);
});



