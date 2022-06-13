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
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\FinanceController;

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
    if (Auth::user()->group_id == 2) {
        return Redirect::to('/recruiter/dashboard');
    }
    if (Auth::user()->group_id == 3) {
        return Redirect::to('vacancies');
    }
    if (Auth::user()->group_id == 4) {
        return Redirect::to('candidates');
    }
    if (Auth::user()->group_id == 5) {
        return Redirect::to('/candidates/arrivals');
    }
    if (Auth::user()->group_id == 6) {
        return Redirect::to('candidates');
    }
})->middleware('auth');

Route::get('login', [AuthController::class, 'getLogin'])->name("login");
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('logout', [AuthController::class, 'getLogout']);
Route::get('/recruiter/invite/{id}', [RecruiterController::class, 'getInvite']);
Route::post('/recruiter/portal/add', [RecruiterController::class, 'getInviteAdd']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('users', [UsersController::class, 'getIndex'])->middleware('roles:1');
    Route::post('users/getJson', [UsersController::class, 'getJson'])->name('users.json')->middleware('roles:1');
    Route::post('users/add', [UsersController::class, 'addUser'])->name('users.add')->middleware('roles:1');
    Route::post('users/fl/add', [UsersController::class, 'addFlUser'])->name('users.fl.add')->middleware('roles:1');
    Route::post('/files/user/add', [UsersController::class, 'filesUserAdd'])->middleware('roles:1');
    Route::get('/users/ajax/id/{id}', [UsersController::class, 'getUserAjax'])->name('users.ajax.id')->middleware('roles:1|2|3');
    Route::get('/users/activation', [UsersController::class, 'usersActivation'])->middleware('roles:1');
    Route::get('/users/auth_by/{id}', [UsersController::class, 'authBy'])->middleware('is_admin')->middleware('roles:1');

    Route::get('user/profile', [UsersController::class, 'getProfile']);
    Route::post('user/profile', [UsersController::class, 'postProfile'])->name('users.profile.save');

    // freelancers
    Route::get('freelancers', [FreelancersController::class, 'getIndex'])->middleware('roles:1|2');
    Route::post('freelancers/getJson', [FreelancersController::class, 'getJson'])->name('freelancers.json')->middleware('roles:1|2');
    Route::get('freelancers/set_fl_status', [FreelancersController::class, 'setFlStatus'])->middleware('roles:1|2');

    // clients
    Route::get('clients', [ClientController::class, 'getIndex'])->middleware('roles:1');
    Route::post('clients/getJson', [ClientController::class, 'getJson'])->name('clients.json')->middleware('roles:1');
    Route::get('clients/activation', [ClientController::class, 'clientsActivation'])->middleware('roles:1');
    Route::get('client/add', [ClientController::class, 'getAdd'])->middleware('roles:1');
    Route::post('client/add', [ClientController::class, 'postAdd'])->name('clients.add')->middleware('roles:1');


    // vacancies
    Route::get('vacancies', [VacancyController::class, 'getIndex'])->middleware('roles:1|2|3');
    Route::get('vacancy/add', [VacancyController::class, 'getAdd'])->middleware('roles:1|2||3');
    Route::post('vacancy/add', [VacancyController::class, 'postAdd'])->name('vacancy.add')->middleware('roles:1|2|3');
    Route::post('files/add', [VacancyController::class, 'filesAdd'])->middleware('roles:1|2|3');
    Route::post('vacancy/getJson', [VacancyController::class, 'getJson'])->name('vacancy.json')->middleware('roles:1|2|3');
    Route::get('vacancy/activation', [VacancyController::class, 'vacancyActivation'])->middleware('roles:1|2|3');
    Route::get('vacancy/changecost', [VacancyController::class, 'vacancyChangecost'])->middleware('roles:1|2|3');

    // candidates
    Route::get('candidates', [CandidateController::class, 'getIndex'])->middleware('roles:1|2|3|4|6');
    Route::post('candidates/getJson', [CandidateController::class, 'getJson'])->name('candidates.json')->middleware('roles:1|2|3|4|6');
    Route::post('candidates/arrivals/getJson', [CandidateController::class, 'getArrivalsJson'])->name('candidates.arrivals.json')->middleware('roles:1|4|6');
    Route::post('candidates/arrivals/all/getJson', [CandidateController::class, 'getArrivalsallJson'])->name('candidates.arrivals.all.json')->middleware('roles:1|4|5');
    Route::get('candidate/set_status', [CandidateController::class, 'setFlStatus'])->middleware('roles:1|2|3|4|6');
    Route::get('candidate/add', [CandidateController::class, 'getAdd'])->middleware('roles:1|2|3|4|5|6');
    Route::post('candidate/add', [CandidateController::class, 'postAdd'])->name('candidate.add')->middleware('roles:1|2|3|4');
    Route::post('candidate/files/doc/add', [CandidateController::class, 'filesDocAdd'])->middleware('roles:1|2|3');
    Route::post('candidate/files/ticket/add', [CandidateController::class, 'filesTicketAdd'])->middleware('roles:1|2|3|4');
    Route::post('candidates/arrivals/add', [CandidateController::class, 'postArrivalAdd'])->middleware('roles:1|4');
    Route::get('candidates/arrivals/activation', [CandidateController::class, 'postArrivalsActivation'])->middleware('roles:1|4');

    // arrivals
    Route::get('candidates/arrivals', [CandidateController::class, 'getArrivals'])->middleware('roles:1|4|5');

    // request transaction
    Route::get('requests', [FinanceController::class, 'getIndex'])->middleware('roles:1|3');
    Route::post('requests/getJson', [FinanceController::class, 'getJson'])->name('finance.json')->middleware('roles:1|3');
    Route::post('requests/add', [FinanceController::class, 'postAdd'])->name('finance.add')->middleware('roles:1|3');


    // handbooks
    Route::get('handbooks', [HandbookController::class, 'getIndex'])->middleware('roles:1');
    Route::get('handbooks/delete', [HandbookController::class, 'deleteHandbook'])->middleware('roles:1');
    Route::get('handbooks/add', [HandbookController::class, 'addHandbook'])->middleware('roles:1');

    //recruiter
    Route::get('/recruiter/dashboard', [RecruiterController::class, 'getIndex'])->middleware('roles:2');


    // ajax search
    Route::get('search/vacancy/client', [SearchController::class, 'getAjaxVacancyClients'])->middleware('roles:1|2|3');
    Route::get('search/vacancy/industry', [SearchController::class, 'getAjaxVacancyIndustry'])->middleware('roles:1|2|3');
    Route::get('search/vacancy/nationality', [SearchController::class, 'getAjaxVacancyNationality'])->middleware('roles:1|2|3');
    Route::get('search/vacancy/workplace', [SearchController::class, 'getAjaxVacancyWorkplace'])->middleware('roles:1|2|3');
    Route::get('search/vacancy/docs', [SearchController::class, 'getAjaxVacancyDocs'])->middleware('roles:1|2|3');

    Route::get('search/client/industry', [SearchController::class, 'getAjaxClientIndustry'])->middleware('roles:1');
    Route::get('search/client/workplace', [SearchController::class, 'getAjaxClientWorkplace'])->middleware('roles:1');
    Route::get('search/client/coordinator', [SearchController::class, 'getAjaxClientCoordinator'])->middleware('roles:1');
    Route::get('search/client/nationality', [SearchController::class, 'getAjaxClientNationality'])->middleware('roles:1');

    Route::get('search/candidate/transport', [SearchController::class, 'getAjaxClientTransport'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/realstatuswork', [SearchController::class, 'getAjaxClientRealstatuswork'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/placearrive', [SearchController::class, 'getAjaxClientPlacearrive'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/typedocs', [SearchController::class, 'getAjaxClientTypedocs'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/country', [SearchController::class, 'getAjaxClientCountry'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/citizenship', [SearchController::class, 'getAjaxClientCitizenship'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/nacionality', [SearchController::class, 'getAjaxClientNacionality'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/vacancy', [SearchController::class, 'getAjaxCandidateVacancy'])->middleware('roles:1|2|3|4|5|6');
    Route::get('search/candidate/recruter', [SearchController::class, 'getAjaxCandidateRecruter'])->middleware('roles:1|2|3|4|5|6');
});



