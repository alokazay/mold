<?php

namespace App\Http\Controllers;

use App\Models\C_file;
use App\Models\Candidate;
use App\Models\Candidate_arrival;
use App\Models\History_candidate;
use App\Models\Task;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    public function getIndex()
    {
        $invited = Candidate::where('user_id', Auth::user()->id)->count();
        $verif = Candidate::where('user_id', Auth::user()->id)->whereNotIn('active', [1, 2])->count();
        $work = Candidate::where('user_id', Auth::user()->id)->whereNotIn('active', [8, 9, 10])->count();
        $cost_pay = Candidate::where('user_id', Auth::user()->id)
            ->whereNotIn('active', [8, 9, 10])->sum('cost_pay');
        return view('candidates.index')
            ->with('cost_pay', $cost_pay)
            ->with('work', $work)
            ->with('verif', $verif)
            ->with('invited', $invited);
    }

    public function getJson()
    {

        $draw = request()->get('draw');
        $start = request()->get("start");
        $rowperpage = request()->get("length"); // Rows display per page

        //ordering
        $order_col = 'id';
        $order_direction = 'desc';
        $cols = request('columns');
        $order = request('order');

        if (isset($order[0]['dir'])) {
            $order_direction = $order[0]['dir'];
        }
        if (isset($order[0]['column']) && isset($cols)) {
            $col_number = $order[0]['column'];
            if (isset($cols[$col_number]) && isset($cols[$col_number]['data'])) {
                $data = $cols[$col_number]['data'];
                if ($data == 0) {
                    $order_col = 'id';
                    $order_direction = 'desc';
                }
            }
        }
        // search
        $status = request('status');
        $search = request('search');
        $vacancies = request('vacancies');
        $clients = request('clients');


        if ($status == '') {
            $users = Candidate::whereIn('active', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]);
        } else {
            $users = Candidate::where('active', $status);
        }

        // Фрилансеры видят только свои
        if (Auth::user()->isFreelancer()) {
            $users = $users->where('user_id', Auth::user()->id);
            $users = $users->whereIn('active', [1, 2, 3, 4, 5, 10]);
        }

        if (Auth::user()->isRecruter()) {
            $users = $users->where('recruiter_id', Auth::user()->id);
            $users = $users->whereIn('active', [1, 2, 3, 5, 13, 14, 15, 16]);
        }

        if (Auth::user()->isLogist()) {
            $users = $users->whereIn('active', [3, 4, 6]);
        }
        if (Auth::user()->isTrud()) {
            $users = $users->whereIn('active', [3, 8, 6]);
        }

        if (Auth::user()->isKoordinator()) {
            $users = $users->whereIn('active', [8]);

            $users = $users->whereHas('client', function ($q) {
                $q->where('coordinator_id', Auth::user()->id);
            });

            if ($clients != '') {
                $users = $users->where('client_id', $clients);
            }

        }


        if ($vacancies != '') {
            $users = $users->where('real_vacancy_id', $vacancies);
        }


        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('viber', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone_parent', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('client')
            ->with('Vacancy')
            ->with('D_file')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {

            if ($u->D_file != null) {
                if (config('app.env') === 'local') {
                    $path_url = url('/');
                } else {
                    $path_url = url('/') . '/public';
                }

                $file = '<a target="_blank" href="' . $path_url . $u->D_file->path . '" style="cursor: pointer;" class="svg-icon svg-icon-2x svg-icon-primary me-4">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
																	<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
																</svg>
															</a>';
            } else {
                $file = '';
            }


            $reason_reject = $u->reason_reject;
            if ($reason_reject != '') {
                $reason_reject = '<br> ' . $u->reason_reject;
            }
            $count_failed_call_btn = '';
            if ($u->active == 15) {
                $count_failed_call_btn = '<button  onclick="setCountFailCall(' . $u->id . ',' . $u->count_failed_call . ')">Недозвон ' . ($u->count_failed_call + 1) . '</button>';
            }
            $select_active = '<select onchange="changeActivation(' . $u->id . ',' . $u->count_failed_call . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                        <option value="">Статус</option>
                                             ' . $u->getStatusOptions() . '
                            </select>' . $reason_reject . $count_failed_call_btn;


            $Vacancy = '';
            if ($u->Vacancy != null) {
                $Vacancy = '<span style="font-size: 11px;line-height: 1;">' . $u->Vacancy->title . '</span>';
            }

            if ($u->date_arrive != null) {
                $date_arrive = Carbon::parse($u->date_arrive)->format('d.m.Y H:i');
            } else {
                $date_arrive = '';
            }

            $temp_arr = [
                //  $checkbox,
                '<a href="candidate/view?id=' . $u->id . '">' . $u->id . '</a>',
                mb_strtoupper($u->firstName),
                mb_strtoupper($u->lastName),
                $u->phone,
                $Vacancy,
                $u->viber,
                $u->phone_parent,
                $date_arrive,
                $file,
                $select_active

            ];
            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => Candidate::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function getLeads()
    {
        return view('candidates.leads.index');
    }

    public function getLeadsJson()
    {

        $draw = request()->get('draw');
        $start = request()->get("start");
        $rowperpage = request()->get("length"); // Rows display per page

        //ordering
        $order_col = 'id';
        $order_direction = 'desc';
        $cols = request('columns');
        $order = request('order');

        if (isset($order[0]['dir'])) {
            $order_direction = $order[0]['dir'];
        }
        if (isset($order[0]['column']) && isset($cols)) {
            $col_number = $order[0]['column'];
            if (isset($cols[$col_number]) && isset($cols[$col_number]['data'])) {
                $data = $cols[$col_number]['data'];
                if ($data == 0) {
                    $order_col = 'id';
                    $order_direction = 'desc';
                }
            }
        }
        // search
        $status = request('status');
        $search = request('search');
        $vacancies = request('vacancies');


        $users = Candidate::whereIn('active', [2]);

        if ($vacancies != '') {
            $users = $users->where('real_vacancy_id', $vacancies);
        }


        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('viber', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone_parent', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('Vacancy')
            ->with('D_file')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {

            if ($u->D_file != null) {
                if (config('app.env') === 'local') {
                    $path_url = url('/');
                } else {
                    $path_url = url('/') . '/public';
                }
                $file = '<a target="_blank" href="' . $path_url . $u->D_file->path . '" style="cursor: pointer;" class="svg-icon svg-icon-2x svg-icon-primary me-4">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
																	<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
																</svg>
															</a>';
            } else {
                $file = '';
            }


            $reason_reject = $u->reason_reject;
            if ($reason_reject != '') {
                $reason_reject = '<br> ' . $u->reason_reject;
            }


            $Vacancy = '';
            if ($u->Vacancy != null) {
                $Vacancy = $u->Vacancy->title;
            }

            if ($u->date_arrive != null) {
                $date_arrive = Carbon::parse($u->date_arrive)->format('d.m.Y H:i');
            } else {
                $date_arrive = '';
            }

            $temp_arr = [
                //  $checkbox,
                '<a href="candidate/view?id=' . $u->id . '">' . $u->id . '</a>',
                mb_strtoupper($u->firstName),
                mb_strtoupper($u->lastName),
                $u->phone,
                $Vacancy,
                $u->viber,
                $u->phone_parent,
                $date_arrive,
                $file
            ];
            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => Candidate::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function getArrivals()
    {
        return view('candidates.arrivals.index');
    }

    function setStatus(Request $r)
    {


        $candidate = Candidate::find($r->id);
        $candidate->count_failed_call = 0;
        if ($candidate->active == 10) {
            if (!Auth::user()->isAdmin()) {
                return response(array('success' => "true", 'error' => 'Статус менять больше нельзя'), 200);
            }
        }
        if ($r->s == 10) {
            return response(array('success' => "true", 'error' => 'Статус менять нельзя, это автостату'), 200);
        }
        if ($r->s == 4) {
            if ($candidate->D_file == null) {
                return response(array('success' => "false", 'error' => 'Загрузите документ'), 200);
            }
        }
        if ($candidate->active == 4) {
            if ($r->s == 6) {
                if (Candidate_arrival::where('candidate_id', $candidate->id)->count() == 0) {
                    return response(array('success' => "true", 'error' => 'Добавте хоть один приезд'), 200);
                }
            }
        }

        if (Auth::user()->isRecruter()) {
            if ($r->s == 2) {
                return response(array('success' => "true", 'error' => 'Статус ставить нельзя'), 200);
            }
        }


        if ($candidate != null) {
            if ($r->s != '') {
                $history = new History_candidate();
                $history->preview_value = $candidate->active;
                $history->new_value = $r->s;
                $history->user_id = Auth::user()->id;
                $history->table_id = 'candidates_active';
                $history->save();
            }


            $candidate->active = $r->s;
            $candidate->reason_reject = $r->r;
            $candidate->save();

            if (Auth::user()->isFreelancer()) {
                if ($candidate->active == 3) {
                    $task = new Task();
                    $task->start = Carbon::now();
                    $task->title = 'Связаться с кандидатом';
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = Auth::user()->id;
                    $task->status = 1;
                    $task->type = 2;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                }

                if ($candidate->active == 2) {
                    $task = new Task();
                    $task->start = Carbon::now();
                    $task->title = 'Обработать лид';
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = Auth::user()->recruter_id;
                    $task->status = 1;
                    $task->type = 3;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                }

            }
            if (Auth::user()->isRecruter()) {


                if ($candidate->active == 3) {
                    $task = new Task();
                    $task->start = Carbon::now();
                    $task->title = 'Связаться с кандидатом';
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = Auth::user()->id;
                    $task->status = 1;
                    $task->type = 3;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                }

            }
            if ($candidate->active == 4) {
                $logists = User::where('group_id', 4)->where('activation', 1)->get();
                foreach ($logists as $logist) {
                    $task = new Task();
                    $task->start = Carbon::now();
                    $task->title = 'Утвердить дату приезда';
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = $logist->id;
                    $task->status = 1;
                    $task->type = 4;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                }

            }
            if ($candidate->active == 6) {
                $trudos = User::where('group_id', 5)->where('activation', 1)->get();
                foreach ($trudos as $trudo) {
                    $task = new Task();
                    $task->start = Carbon::now();
                    $task->title = 'Встретить кандидата и подписать договор';
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = $trudo->id;
                    $task->status = 1;
                    $task->type = 9;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                }

            }

            if ($candidate->active == 8) {
                $Clinets_c_id = [];


                if ($candidate->Vacancy != null) {
                    foreach ($candidate->Vacancy->Vacancy_client as $client) {
                        if ($client->Client != null) {
                            if (!in_array($client->Client->coordinator_id, $Clinets_c_id)) {
                                $Clinets_c_id[] = $client->Client->coordinator_id;
                            }

                        }
                    }
                }

                foreach ($Clinets_c_id as $Cl_id) {
                    $task = new Task();
                    $task->start = Carbon::now();
                    $task->title = 'Указать первый рабочий день';
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = $Cl_id;
                    $task->status = 1;
                    $task->type = 6;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                }

            }

        }

        return response(array('success' => "true"), 200);
    }

    function setStatusSpecial(Request $r)
    {
        $candidate = Candidate::find($r->id);

        if ($candidate != null) {
            if ($r->status != '') {
                $history = new History_candidate();
                $history->preview_value = $candidate->active;
                $history->new_value = $r->status;
                $history->user_id = Auth::user()->id;
                $history->table_id = 'candidates_active';
                $history->save();
            }

            if ($r->status == 13) {
                $candidate->active = $r->status;
                $candidate->reason_reject = $r->comment;
                $candidate->save();
            }
            if ($r->status == 14) {
                $candidate->active = $r->status;
                $candidate->reason_reject = $r->comment;
                $candidate->save();

                $task = new Task();
                $task->title = 'Перезвонить: ' . $r->comment;
                $task->start = Carbon::createFromFormat('d.m.Y', $r->date);
                $task->autor_id = Auth::user()->id;
                $task->to_user_id = Auth::user()->id;
                $task->status = 1;
                $task->type = 10;
                $task->candidate_id = $candidate->id;
                $task->save();
            }
            if ($r->status == 15) {
                $candidate->active = $r->status;
                $candidate->save();

                if ($candidate->count_failed_call > 3) {
                    $candidate->count_failed_call = 0;
                    $candidate->save();
                }


                if ($candidate->count_failed_call == 2) {

                    $candidate->count_failed_call = 0;
                    $candidate->save();

                    $task = new Task();
                    $task->title = $r->comment;
                    $task->start = Carbon::createFromFormat('d.m.Y', $r->date);
                    $task->autor_id = Auth::user()->id;
                    $task->to_user_id = Auth::user()->id;
                    $task->status = 1;
                    $task->type = 11;
                    $task->candidate_id = $candidate->id;
                    $task->save();
                } else {
                    $candidate->count_failed_call = $candidate->count_failed_call + 1;
                    $candidate->save();
                }

            }
            if ($r->status == 16) {
                $candidate->active = $r->status;
                $candidate->reason_reject = $r->comment;
                $candidate->save();

                $task = new Task();
                $task->title = $r->comment;
                $task->start = Carbon::createFromFormat('d.m.Y', $r->date);
                $task->autor_id = Auth::user()->id;
                $task->to_user_id = Auth::user()->id;
                $task->status = 1;
                $task->type = 12;
                $task->candidate_id = $candidate->id;
                $task->save();
            }
        }


        return response(array('success' => "true"), 200);
    }

    public function getAdd(Request $r)
    {

        if (Auth::user()->isFreelancer()) {
            if (Auth::user()->fl_status != 2) {
                return response(array('success' => "false"), 200);
            }
        }

        $vacancy = null;


        if ($r->has('id')) {
            $canddaite = Candidate::where('id', $r->id)
                ->with('Vacancy')
                ->with('Citizenship')
                ->with('Nacionality')
                ->with('Country')
                ->with('Type_doc')
                ->with('Logist_place_arrive')
                ->with('Real_status_work')
                ->with('Transport')
                ->with('Client')
                ->first();

            $reason_reject = $canddaite->reason_reject;
            if ($reason_reject != '') {
                $reason_reject = '<br> ' . $canddaite->reason_reject;
            }
            $count_failed_call_btn = '';
            if ($canddaite->active == 15) {
                $count_failed_call_btn = '<button  onclick="setCountFailCall(' . $canddaite->id . ',' . $canddaite->count_failed_call . ')">Недозвон ' . ($canddaite->count_failed_call + 1) . '</button>';
            }
            $select_active = '<select onchange="changeActivation(' . $canddaite->id . ',' . $canddaite->count_failed_call . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $canddaite->id . '">
                                        <option value="">Статус</option>
                                             ' . $canddaite->getStatusOptions() . '
                            </select>' . $reason_reject . $count_failed_call_btn;

        } else {
            $canddaite = null;
            $select_active = null;

            if ($r->has('vid')) {
                $vacancy = Vacancy::find($r->vid);
            }
        }

        $recruter = null;
        if ($r->has('r_id')) {
            $recruter = User::find($r->r_id);
        } else {
            if ($canddaite != null) {
                $recruter = User::find($canddaite->recruiter_id);
            }
        }


        return view('candidates.add')
            ->with('select_active', $select_active)
            ->with('recruter', $recruter)
            ->with('vacancy', $vacancy)
            ->with('canddaite', $canddaite);
    }
    public function getView(Request $r)
    {

        if (Auth::user()->isFreelancer()) {
            if (Auth::user()->fl_status != 2) {
                return response(array('success' => "false"), 200);
            }
        }

        $vacancy = null;


        if ($r->has('id')) {
            $canddaite = Candidate::where('id', $r->id)
                ->with('Vacancy')
                ->with('Citizenship')
                ->with('Nacionality')
                ->with('Country')
                ->with('Type_doc')
                ->with('Logist_place_arrive')
                ->with('Real_status_work')
                ->with('Transport')
                ->with('Client')
                ->first();

            $reason_reject = $canddaite->reason_reject;
            if ($reason_reject != '') {
                $reason_reject = '<br> ' . $canddaite->reason_reject;
            }
            $count_failed_call_btn = '';
            if ($canddaite->active == 15) {
                $count_failed_call_btn = '<button  onclick="setCountFailCall(' . $canddaite->id . ',' . $canddaite->count_failed_call . ')">Недозвон ' . ($canddaite->count_failed_call + 1) . '</button>';
            }
            $select_active = '<select onchange="changeActivation(' . $canddaite->id . ',' . $canddaite->count_failed_call . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $canddaite->id . '">
                                        <option value="">Статус</option>
                                             ' . $canddaite->getStatusOptions() . '
                            </select>' . $reason_reject . $count_failed_call_btn;

        } else {
            return response(array('success' => "false", 'error' => 'candidate not found'), 200);
        }

        $recruter = null;
        if ($r->has('r_id')) {
            $recruter = User::find($r->r_id);
        } else {
            if ($canddaite != null) {
                $recruter = User::find($canddaite->recruiter_id);
            }
        }


        return view('candidates.view')
            ->with('select_active', $select_active)
            ->with('recruter', $recruter)
            ->with('vacancy', $vacancy)
            ->with('canddaite', $canddaite);
    }

    /*
    Add Candidate
    */
    public function postAdd(Request $r)
    {
        if (Auth::user()->isFreelancer()) {
            if (Auth::user()->fl_status != 2) {
                return response(array('success' => "false"), 200);
            }
        }

        $niceNames = [
            'lastName' => '«Фамилия»',
            'firstName' => '«Имя»',
            'phone' => '«Телефон»',
            'viber' => '«viber»',
            'dateOfBirth' => '«Дата»',
        ];
        $validate_arr = [
            'lastName' => 'required',
            'firstName' => 'required',
            'phone' => 'required|regex:/\+[0-9]{9,12}/',
            'viber' => 'required|regex:/\+[0-9]{9,12}/',
            'dateOfBirth' => 'required|date_format:d.m.Y',
        ];

        $validator = Validator::make($r->all(), $validate_arr, [], $niceNames);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response(array('success' => "false", 'error' => $error), 200);
        }


        $diff_year = Carbon::now()->diffInYears(Carbon::createFromFormat('d.m.Y', $r->dateOfBirth));
        if ($diff_year < 18) {
            return response(array('success' => "false", 'error' => 'Возраст менее 18'), 200);
        }


        $candidate = Candidate::find($r->id);
        if ($candidate == null) {


            $niceNames = [
                'phone' => '«Телефон»',
                'inn' => '«ИНН»',
            ];
            $validator = Validator::make($r->all(), [
                'phone' => 'required|regex:/\+[0-9]{9,12}/|unique:candidates,phone',
                'inn' => 'required|numeric|unique:candidates,inn'
            ], [], $niceNames);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }


            $is_new = true;
            $candidate = new Candidate();
            $candidate->user_id = Auth::user()->id;
            $candidate->active = 1;


            if (Auth::user()->isRecruter()) {
                if ($candidate->D_file == null) {
                    return response(array('success' => "false", 'error' => 'Загрузите документ'), 200);
                }
            }


        } else {
            $is_new = false;
            $niceNames = [
                'phone' => '«Телефон»',
                'inn' => '«ИНН»',
            ];
            $validator = Validator::make($r->all(), [
                'phone' => 'required|regex:/\+[0-9]{9,12}/|unique:candidates,phone,' . $candidate->id,
                'inn' => 'required|numeric|unique:candidates,inn,' . $candidate->id
            ], [], $niceNames);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }

            if (Auth::user()->isRecruter()) {
                if ($candidate->D_file == null) {
                    return response(array('success' => "false", 'error' => 'Загрузите документ'), 200);
                }
            }


        }

        if ($is_new == false) {
            if (Auth::user()->isTrud()) {
                $niceNames = [
                    'real_vacancy_id' => '«Вакансия»',
                    'real_status_work_id' => '«Статус трудоустройства»',
                    'client_id' => '«Клиент»'
                ];
                $validator = Validator::make($r->all(), [
                    'real_vacancy_id' => 'required',
                    'real_status_work_id' => 'required',
                    'client_id' => 'required'
                ], [], $niceNames);
                if ($validator->fails()) {
                    $error = $validator->errors()->first();
                    return response(array('success' => "false", 'error' => $error), 200);
                }
            }
        }

        if (Auth::user()->isFreelancer()) {
            $candidate->recruiter_id = Auth::user()->recruter_id;
        }
        if (Auth::user()->isRecruter()) {
            $candidate->recruiter_id = Auth::user()->id;
        }
        if (Auth::user()->isAdmin()) {
            $candidate->recruiter_id = $r->recruiter_id;
        }


        $candidate->lastName = $r->lastName;
        $candidate->firstName = $r->firstName;
        $candidate->phone = $r->phone;
        $candidate->viber = $r->viber;

        if ($r->dateOfBirth != '' && $r->dateOfBirth != 'undefined') {

            $candidate->dateOfBirth = Carbon::createFromFormat('d.m.Y', $r->dateOfBirth);
        }
        if ($r->phone_parent != '' && $r->phone_parent != 'undefined') {
            $candidate->phone_parent = $r->phone_parent;
        }
        if ($r->citizenship_id != '' && $r->citizenship_id != 'undefined') {
            $candidate->citizenship_id = $r->citizenship_id;
        }
        if ($r->nacionality_id != '' && $r->nacionality_id != 'undefined') {
            $candidate->nacionality_id = $r->nacionality_id;
        }
        if ($r->country_id != '' && $r->country_id != 'undefined') {
            $candidate->country_id = $r->country_id;
        }
        if ($r->date_arrive != '' && $r->date_arrive != 'undefined') {
            if (Carbon::now()->diffInYears(Carbon::createFromFormat('d.m.Y', $r->date_arrive)) > 10) {
                return response(array('success' => "false", 'error' => 'Исправте дату приезда'), 200);
            }
            $candidate->date_arrive = Carbon::createFromFormat('d.m.Y', $r->date_arrive);
        }
        if ($r->type_doc_id != '' && $r->type_doc_id != 'undefined') {
            $candidate->type_doc_id = $r->type_doc_id;
        }
        if ($r->transport_id != '' && $r->transport_id != 'undefined') {
            $candidate->transport_id = $r->transport_id;
        }
        if ($r->inn != '' && $r->inn != 'undefined') {
            $candidate->inn = $r->inn;
        }
        if ($r->comment != '' && $r->comment != 'undefined') {
            $candidate->comment = $r->comment;
        }

        // logist
        if ($r->logist_date_arrive != '' && $r->logist_date_arrive != 'undefined') {

            $candidate->logist_date_arrive = Carbon::createFromFormat('d.m.Y H:i', $r->logist_date_arrive);
        }
        if ($r->logist_place_arrive_id != '' && $r->logist_place_arrive_id != 'undefined') {
            $candidate->logist_place_arrive_id = $r->logist_place_arrive_id;
        }
        // logist

        // trudo
        if ($r->real_vacancy_id != '' && $r->real_vacancy_id != 'undefined') {
            $candidate->real_vacancy_id = $r->real_vacancy_id;
        }
        if ($r->client_id != '' && $r->client_id != 'undefined') {
            $candidate->client_id = $r->client_id;
        }
        if ($r->real_status_work_id != '' && $r->real_status_work_id != 'undefined') {
            $candidate->real_status_work_id = $r->real_status_work_id;
        }
        // trudo

        $candidate->save();

        // Фиксируем для кандидата текущую ставку
        $candidate = Candidate::find($candidate->id);
        if ($candidate->Vacancy != null) {
            $candidate->cost_pay = $candidate->Vacancy->recruting_cost;
            $candidate->cost_pay_lead = $candidate->Vacancy->cost_pay_lead;
            $candidate->save();
        }

        // Авто задачи
        if ($is_new) {
            if (Auth::user()->isFreelancer()) {
                $task = new Task();
                $task->start = Carbon::now();
                $task->title = 'Обработать кандидата';
                $task->autor_id = Auth::user()->id;
                $task->to_user_id = Auth::user()->id;
                $task->status = 1;
                $task->type = 1;
                $task->candidate_id = $candidate->id;
                $task->save();
            }
        }


        return Response::json(array('success' => "true", 200));
    }

    public function filesDocAdd()
    {

        $c_id = request()->get('id');
        if ($c_id == '') {


            $niceNames = [
                'lastName' => '«Фамилия»',
                'firstName' => '«Имя»',
                'phone' => '«Телефон»',
                'viber' => '«viber»',
                'dateOfBirth' => '«Дата»',
            ];
            $validate_arr = [
                'lastName' => 'required',
                'firstName' => 'required',
                'phone' => 'required|regex:/\+[0-9]{9,12}/',
                'viber' => 'required|regex:/\+[0-9]{9,12}/',
                'dateOfBirth' => 'required|date_format:d.m.Y',
            ];

            $validator = Validator::make(request()->all(), $validate_arr, [], $niceNames);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }

            $candidate = new Candidate();
            $candidate->user_id = Auth::user()->id;
            $candidate->active = 1;
            $candidate->save();
            $c_id = $candidate->id;
        }

        $file = request()->file('file');
        if ($file->isValid()) {

            $path = '/uploads/candidate/' . Carbon::now()->format('m.Y') . '/' . $c_id . '/files/';
            $name = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($path), $name);
            $file_link = $path . $name;


            C_file::where('candidate_id',$c_id)->where('type', request('type'))->delete();

            $file = new C_file();
            $file->autor_id = Auth::user()->id;
            $file->candidate_id = $c_id;
            $file->user_id = Auth::user()->id;
            $file->type = request('type');
            $file->original_name = request()->file('file')->getClientOriginalName();
            $file->ext = request()->file('file')->getClientOriginalExtension();
            $file->path = $file_link;
            $file->save();

            return Response::json(array('success' => "true",
                'id' => $c_id,
                'path' => url('/') . '' . $file_link
            ), 200);
        } else {
            return Response::json(array('success' => "false",
                'error' => 'file not valid!'
            ), 200);
        }
    }

    public function filesTicketAdd()
    {

        $c_id = request()->get('id');
        if ($c_id == '') {
            $candidate = new Candidate();
            $candidate->user_id = Auth::user()->id;
            $candidate->active = 1;
            $candidate->save();
            $c_id = $candidate->id;
        }

        $file = request()->file('file');
        if ($file->isValid()) {

            $path = '/uploads/candidate/' . Carbon::now()->format('m.Y') . '/' . $c_id . '/files/';
            $name = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($path), $name);
            $file_link = $path . $name;


            $file = new C_file();
            $file->autor_id = Auth::user()->id;
            $file->candidate_id = $c_id;
            $file->user_id = Auth::user()->id;
            $file->type = 4;
            $file->original_name = request()->file('file')->getClientOriginalName();
            $file->ext = request()->file('file')->getClientOriginalExtension();
            $file->path = $file_link;
            $file->save();

            return Response::json(array('success' => "true",
                'id' => $c_id,
                'path' => url('/') . '' . $file_link
            ), 200);
        } else {
            return Response::json(array('success' => "false",
                'error' => 'file not valid!'
            ), 200);
        }
    }

    public function getArrivalsJson()
    {
        $draw = request()->get('draw');
        $start = request()->get("start");
        $rowperpage = request()->get("length"); // Rows display per page

        //ordering
        $order_col = 'id';
        $order_direction = 'desc';
        $cols = request('columns');
        $order = request('order');

        if (isset($order[0]['dir'])) {
            $order_direction = $order[0]['dir'];
        }
        if (isset($order[0]['column']) && isset($cols)) {
            $col_number = $order[0]['column'];
            if (isset($cols[$col_number]) && isset($cols[$col_number]['data'])) {
                $data = $cols[$col_number]['data'];
                if ($data == 0) {
                    $order_col = 'id';
                    $order_direction = 'desc';
                }
            }
        }
        // search
        $status = request('status');
        $search = request('search');


        if ($status == '') {
            $users = Candidate_arrival::whereIn('status', [0, 1, 2, 3]);
        } else {
            $users = Candidate_arrival::where('status', $status);
        }
        $users = $users->where('candidate_id', request('canddaite_id'));


        if ($search != '') {

        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('Place_arrive')
            ->with('Transport')
            ->with('D_file')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {


            if ($u->D_file != null) {

                if (config('app.env') === 'local') {
                    $path_url = url('/');
                } else {
                    $path_url = url('/') . '/public';
                }

                $file = '<a   href="javascript:;"><i data-id="' . $u->id . '" id="file_' . $u->id . '"  class="fa fa-pen add_file"></i></a>';
                $file .= '<a target="_blank" href="' . $path_url . $u->D_file->path . '" style="cursor: pointer;" class="svg-icon svg-icon-2x svg-icon-primary me-4">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
																	<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
																</svg>
															</a>';
            } else {
                $file = '<a data-id="' . $u->id . '" id="file_' . $u->id . '" class="add_file" href="javascript:;">загрузить</a>';
            }

            $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                        <option value="">Статус</option>
                                             ' . $u->getStatusOptions() . '
                            </select>';


            if ($u->Vacancy != null) {
                $Vacancy = $u->Vacancy->title;
            }

            if ($u->date_arrive != null) {
                $date_arrive = Carbon::parse($u->date_arrive)->format('d.m.Y');
                $date_arrive_time = Carbon::parse($u->date_arrive)->format('H:i');
            } else {
                $date_arrive = '';
                $date_arrive_time = '';
            }
            if ($u->Place_arrive != null) {
                $Place_arrive = $u->Place_arrive->name;
            } else {
                $Place_arrive = '';
            }
            if ($u->Transport != null) {
                $Transport = $u->Transport->name;
            } else {
                $Transport = '';
            }

            $temp_arr = [
                //  $checkbox,
                '<a data-comment="' . $u->comment . '" data-place_arrive_name="' . $Place_arrive . '" data-transport_name="' . $Transport . '" data-id="' . $u->id . '" data-date_arrive="' . Carbon::parse($u->date_arrive)->format('d.m.Y H:i') . '" data-transport_id="' . $u->transport_id . '" data-place_arrive_id="' . $u->place_arrive_id . '" class="edit_arrival" href="javascript:;"><i class="fa fa-pen"></i></a>',
                $u->comment,
                $Place_arrive,
                $date_arrive,
                $date_arrive_time,
                $Transport,
                $file,
                $select_active

            ];
            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => User::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function getArrivalsallJson()
    {
        $draw = request()->get('draw');
        $start = request()->get("start");
        $rowperpage = request()->get("length"); // Rows display per page

        //ordering
        $order_col = 'date_arrive';
        $order_direction = 'desc';
        $cols = request('columns');
        $order = request('order');

        if (isset($order[0]['dir'])) {
            $order_direction = $order[0]['dir'];
        }
        if (isset($order[0]['column']) && isset($cols)) {
            $col_number = $order[0]['column'];
            if (isset($cols[$col_number]) && isset($cols[$col_number]['data'])) {
                $data = $cols[$col_number]['data'];
                if ($data == 0) {
                    $order_col = 'date_arrive';
                    $order_direction = 'asc';
                }
            }
        }
        // search
        $status = request('status');
        $search = request('search');
        $date_start = request('date_start');
        $date_to = request('date_to');


        if ($status == '') {
            $users = Candidate_arrival::whereIn('status', [1]);
        } else {
            $users = Candidate_arrival::where('status', $status);
        }

        if (Auth::user()->isLogist()) {
            $users = $users->whereIn('status', [0, 1, 3]);
        }

        if ($search != '') {
            $cand_ids = Candidate::where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('viber', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone_parent', 'LIKE', '%' . $search . '%');
            })->limit(10)->pluck('id');

            $users = $users->whereIn('candidate_id', $cand_ids);

        }
        if ($date_start != '') {
            $users = $users->where('date_arrive', '>=', Carbon::createFromFormat('d.m.Y H:i', $date_start));
        }

        if ($date_to != '') {
            $users = $users->where('date_arrive', '<=', Carbon::createFromFormat('d.m.Y H:i', $date_to));
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('Place_arrive')
            ->with('Transport')
            ->with('Candidate')
            ->with('Candidate.Nacionality')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {

            if ($u->D_file != null) {

                if (config('app.env') === 'local') {
                    $path_url = url('/');
                } else {
                    $path_url = url('/') . '/public';
                }

                $file = '<a target="_blank" href="' . $path_url . $u->D_file->path . '" style="cursor: pointer;" class="svg-icon svg-icon-2x svg-icon-primary me-4">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
																	<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
																</svg>
															</a>';
            } else {
                $file = '';
            }

            $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                        <option value="">Статус</option>
                                             ' . $u->getStatusOptions() . '
                            </select>';


            if ($u->date_arrive != null) {
                $date_arrive = Carbon::parse($u->date_arrive)->format('d.m.Y');
                $date_arrive_time = Carbon::parse($u->date_arrive)->format('H:i');
            } else {
                $date_arrive = '';
                $date_arrive_time = '';
            }
            if ($u->Place_arrive != null) {
                $Place_arrive = $u->Place_arrive->name;
            } else {
                $Place_arrive = '';
            }
            if ($u->Transport != null) {
                $Transport = $u->Transport->name;
            } else {
                $Transport = '';
            }
            if ($u->Candidate != null && $u->Candidate->Nacionality != null) {
                $Nacionality = $u->Candidate->Nacionality->name;
            } else {
                $Nacionality = '';
            }

            if ($u->Candidate != null && $u->Candidate->Vacancy != null) {
                $Vacancy = $u->Candidate->Vacancy->title;
            } else {
                $Vacancy = '';
            }

            $temp_arr = [
                //  $checkbox,
                '<a href="' . url('/') . '/candidate/view?id=' . $u->candidate_id . '">' . $u->id . '</a>',
                mb_strtoupper($u->Candidate->firstName),
                mb_strtoupper($u->Candidate->lastName),
                $u->Candidate->phone,
                $u->Candidate->viber,
                $Nacionality,
                $Vacancy,
                $Place_arrive,
                $Transport,
                '<a data-comment="' . $u->comment . '" data-place_arrive_name="' . $Place_arrive . '" data-transport_name="' . $Transport . '" data-id="' . $u->id . '" data-date_arrive="' . Carbon::parse($u->date_arrive)->format('d.m.Y H:i') . '" data-transport_id="' . $u->transport_id . '" data-place_arrive_id="' . $u->place_arrive_id . '" class="edit_arrival" href="javascript:;">' . $date_arrive . '</a>',
                $date_arrive_time,
                $file,
                $u->comment,
                $select_active
            ];
            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => Candidate_arrival::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function postArrivalAdd(Request $r)
    {

        if ($r->has('id')) {
            $niceNames = [
                'place_arrive_id' => '«Место»',
                'transport_id' => '«Транспорт»',
                'date_arrive' => '«Дата»',
            ];
            $validator = Validator::make($r->all(), [
                'place_arrive_id' => 'required',
                'transport_id' => 'required',
                'date_arrive' => 'required'
            ], [], $niceNames);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }

            $arrival = Candidate_arrival::find($r->id);
            $candidate = Candidate::find($arrival->candidate_id);
        } else {
            $niceNames = [
                'place_arrive_id' => '«Место»',
                'transport_id' => '«Транспорт»',
                'date_arrive' => '«Дата»',
                'candidate_id' => '«ID»',
            ];
            $validator = Validator::make($r->all(), [
                'place_arrive_id' => 'required',
                'transport_id' => 'required',
                'date_arrive' => 'required',
                'candidate_id' => 'required',
            ], [], $niceNames);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }
            $candidate = Candidate::find($r->candidate_id);
            if ($candidate == null) {
                return response(array('success' => "false", 'error' => 'Кандидат не найден'), 200);
            }
            $arrival = Candidate_arrival::find($r->id);
        }


        if ($arrival == null) {
            $arrival = new  Candidate_arrival();


            //  Auto task
            $task = new Task();
            $task->title = 'Перезвонить  кандидату';
            $task->autor_id = Auth::user()->id;
            $task->to_user_id = Auth::user()->id;
            $task->start = Carbon::createFromFormat('d.m.Y H:i', $r->date_arrive)->subDays(1);
            $task->status = 1;
            $task->type = 13;
            $task->candidate_id = $candidate->id;
            $task->save();

            $arrival->status = 0;
            $arrival->task_id = $task->id;
        }


        $arrival->place_arrive_id = $r->place_arrive_id;
        $arrival->transport_id = $r->transport_id;
        $arrival->comment = $r->comment;
        $arrival->date_arrive = Carbon::createFromFormat('d.m.Y H:i', $r->date_arrive);
        $arrival->candidate_id = $candidate->id;
        $arrival->save();

        // Update task
        $task = Task::find($arrival->task_id);
        if ($task !== null) {
            $task->start = Carbon::createFromFormat('d.m.Y H:i', $r->date_arrive)->subDays(1);
            $task->save();
        }


        /*       $candidate->transport_id = $r->transport_id;
               $candidate->logist_place_arrive_id = $r->place_arrive_id;
               $candidate->logist_date_arrive = Carbon::createFromFormat('d.m.Y H:i', $r->date_arrive);
               $candidate->save();*/
        return response(array('success' => "true"), 200);

    }

    public function postArrivalsActivation(Request $r)
    {

        if (Auth::user()->isTrud()) {
            if ($r->s == 1) {
                return response(array('success' => "false", 'error' => 'У вас нет прав ставить статус в пути'), 200);
            }
        }

        $arrivals = Candidate_arrival::find($r->id);
        if ($arrivals != null) {
            Candidate_arrival::where('id', $r->id)->update(['status' => $r->s]);
        }

        return response(array('success' => "true"), 200);
    }

    public function addTicketDoc()
    {
        $r_id = request()->get('id');
        $file = request()->file('file');
        if ($file->isValid()) {

            $path = '/uploads/tickets/' . Carbon::now()->format('m.Y') . '/' . $r_id . '/files/';
            $name = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($path), $name);
            $file_link = $path . $name;


            $file = new C_file();
            $file->autor_id = Auth::user()->id;
            $file->user_id = Auth::user()->id;
            $file->type = 6;
            $file->original_name = request()->file('file')->getClientOriginalName();
            $file->ext = request()->file('file')->getClientOriginalExtension();
            $file->path = $file_link;
            $file->save();

            $finance = Candidate_arrival::find($r_id);
            $finance->file_id = $file->id;
            $finance->save();

            return Response::json(array('success' => "true",
                'path' => url('/') . '' . $file_link
            ), 200);
        } else {
            return Response::json(array('success' => "false",
                'error' => 'file not valid!'
            ), 200);
        }
    }
}
