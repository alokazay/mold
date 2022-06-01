<?php

namespace App\Http\Controllers;

use App\Models\C_file;
use App\Models\Candidate;
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
        return view('candidates.index');
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


        if ($status == '') {
            $users = Candidate::whereIn('active', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
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
            $users = $users->whereIn('active', [1, 2, 3, 4, 5]);
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
            ->with('Vacancy')
            ->with('D_file')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {

            if ($u->D_file != null) {
                $file = '<a target="_blank" href="' . url('/') . $u->D_file->path . '" style="cursor: pointer;" class="svg-icon svg-icon-2x svg-icon-primary me-4">
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
                '<a href="candidate/add?id=' . $u->id . '">' . $u->id . '</a>',
                $u->firstName,
                $u->lastName,
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
            "recordsTotal" => User::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    function setFlStatus(Request $r)
    {
        Candidate::where('id', $r->id)->update(['active' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function getAdd(Request $r)
    {
        $vacancy = null;


        if ($r->has('id')) {
            $canddaite = Candidate::where('id', $r->id)
                ->with('Vacancy')
                ->with('Citizenship')
                ->with('Country')
                ->with('Type_doc')
                ->with('Logist_place_arrive')
                ->with('Real_status_work')
                ->with('Transport')
                ->first();
        } else {
            $canddaite = null;

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
            ->with('recruter', $recruter)
            ->with('vacancy', $vacancy)
            ->with('canddaite', $canddaite);
    }

    public function postAdd(Request $r)
    {
        $niceNames = [
            'lastName' => '«Фамилия»',
            'firstName' => '«Имя»',
            'phone' => '«Телефон»',
            'viber' => '«viber»',
        ];
        $validator = Validator::make($r->all(), [
            'lastName' => 'required',
            'firstName' => 'required',
            'phone' => 'required',
            'viber' => 'required',
        ], [], $niceNames);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response(array('success' => "false", 'error' => $error), 200);
        }

        $candidate = Candidate::find($r->id);
        if ($candidate == null) {
            $candidate = new Candidate();
            $candidate->user_id = Auth::user()->id;
            $candidate->active = 1;
        }

        $candidate->recruiter_id = $r->recruiter_id;
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
        if ($r->country_id != '' && $r->country_id != 'undefined') {
            $candidate->country_id = $r->country_id;
        }
        if ($r->date_arrive != '' && $r->date_arrive != 'undefined') {
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
        if ($r->real_status_work_id != '' && $r->real_status_work_id != 'undefined') {
            $candidate->real_status_work_id = $r->real_status_work_id;
        }
        // trudo
        $candidate->save();
        return Response::json(array('success' => "true", 200));
    }

    public function filesDocAdd()
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
            $file->type = 3;
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
}
