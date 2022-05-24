<?php

namespace App\Http\Controllers;

use App\Models\C_file;
use App\Models\Candidate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
            $users = Candidate::whereIn('active', [1, 2]);
        } else {
            $users = Candidate::where('active', $status);
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

            if ($u->active == 1 || $u->active == '') {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                         <option  selected value="1">Ожидается</option>
                                            <option value="2">Подтвержден</option>
                            </select>';
            } else if ($u->active == 2) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                         <option value="1">Ожидается</option>
                                            <option selected value="2">Подтвержден</option>
                            </select>';
            }

            $Vacancy = '';
            if ($u->Vacancy != null) {
                $Vacancy = $u->Vacancy->title;
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
                Carbon::parse($u->logist_date_arrive)->format('d.m.Y H:i'),
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

    function setFlStatus (Request $r){
        Candidate::where('id', $r->id)->update(['active' => $r->s]);
        return response(array('success' => "true"), 200);
    }

}
