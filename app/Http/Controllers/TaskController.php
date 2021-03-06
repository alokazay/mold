<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Candidate_arrival;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    public function getIndex()
    {
        return view('tasks.index');
    }

    public function getJson()
    {

        $draw = request()->get('draw');
        $start = request()->get("start");
        $rowperpage = request()->get("length"); // Rows display per page

        //ordering
        $order_col = 'start';
        $order_direction = 'desc';
        $cols = request('columns');
        $order = request('order');

        if (isset($order[0]['dir'])) {
            $order_direction = $order[0]['dir'];
        }
        // if (isset($order[0]['column']) && isset($cols)) {
        //     $col_number = $order[0]['column'];
        //     if (isset($cols[$col_number]) && isset($cols[$col_number]['data'])) {
        //         $data = $cols[$col_number]['data'];
        //         if ($data == 0) {
        //             $order_col = 'id';
        //             $order_direction = 'desc';
        //         }

        //     }
        // }
        // search
        $filter__status = request('status');
        $search = request('search');
        $filter__period = request('period');

        $users = Task::where('to_user_id', Auth::user()->id)
            ->where(function ($query) use ($filter__status) {
                if ($filter__status == '') {
                    return $query->whereIn('status', [1]);
                } else {
                    return $query->where('status', $filter__status);
                }
            })
            ->when($filter__period, function ($query, $period) {
                if ($period == 'today') {
                    return $query->whereDate('start', '>=', Carbon::now()->subDays(1))
                        ->whereDate('start', '<', Carbon::now()->addDays(1));
                } elseif ($period == 'yesterday') {
                    return $query->whereDate('start', Carbon::now()->subDays(1));
                } elseif ($period == 'lastWeek') {
                    return $query->whereDate('start', '>', Carbon::now()->subDays(7))
                        ->whereDate('start', '<', Carbon::now()->addDays(1));
                } elseif ($period == 'lastMonth') {
                    return $query->whereDate('start', '>', Carbon::now()->subDays(30))
                        ->whereDate('start', '<', Carbon::now()->addDays(1));
                }
            });

        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
            });
        }


        $users = $users->orderBy($order_col, $order_direction);

        $users = $users
            ->with('Autor')
            ->with('Candidate')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {

            if ($u->status == 1) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                <option selected value="1">?? ????????????????????</option>
                                <option value="2">??????????????????</option>
                            </select>';
            } else {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                <option value="1">?? ????????????????????</option>
                                <option selected value="2">??????????????????</option>
                            </select>';
            }

            $Autor = '';
            if ($u->Autor != null) {
                $Autor = $u->Autor->firstName . ' ' . $u->Autor->lastName;
            }

            $Candidate = '';
            if ($u->Candidate != null) {
                $Candidate = '<a href="' . url('/') . '/candidate/view?id=' . $u->Candidate->id . '">' . $u->Candidate->firstName . ' ' . $u->Candidate->lastName . '</a>';
            }

            $temp_arr = [
                '<a href="javascript:;" onclick="editTask(' . $u->id . ')">' . $u->id . '</a>',
                Carbon::parse($u->start)->format('d.m.Y'),
                $u->title,
                $Autor,
                $Candidate,
                $select_active

            ];
            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => Task::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function tasksActivation(Request $r)
    {

        $task = Task::where('id', $r->id)->first();

        $candidate = Candidate::find($r->id);
        if ($candidate != null ) {
            if($task->type == 4){
                if ($r->s == 2) {
                    if (Candidate_arrival::where('candidate_id', $candidate->id)->count() == 0) {
                        return response(array('success' => "true", 'error' => '?????????????? ???????? ???????? ????????????'), 200);
                    }
                }
            }

            if(Auth::user()->isTrud()){
                // ?????????????? ???????????? ?????????????? ????????
                if($task->type == 6){
                    if($candidate->real_vacancy_id == '' || $candidate->real_vacancy_id == null){
                        return response(array('success' => "true", 'error' => '?????????????? ????????????????'), 200);
                    }
                    if($candidate->real_status_work_id == '' || $candidate->real_status_work_id == null){
                        return response(array('success' => "true", 'error' => '?????????????? ???????????? ??????????????????????????????'), 200);
                    }
                    if($candidate->client_id == '' || $candidate->client_id == null){
                        return response(array('success' => "true", 'error' => '?????????????? ??????????????'), 200);
                    }
                }
            }
        }

        $task->status = $r->s;
        $task->save();

        return response(array('success' => "true"), 200);
    }

    public function getTaskAjax($id)
    {
        $task = Task::where('id', $id)->with('Autor')->with('Candidate')->first();
        if ($task == null) {
            return response(array('success' => "false", 'error' => '???????????? ???? ??????????????!'), 200);
        }


        $Autor = '';
        if ($task->Autor != null) {
            $Autor = $task->Autor->firstName . ' ' . $task->Autor->lastName;
        }

        $Candidate = '';
        if ($task->Candidate != null) {
            $Candidate = '<a href="' . url('/') . '/candidate/view?id=' . $task->Candidate->id . '">' . $task->Candidate->firstName . ' ' . $task->Candidate->lastName . '</a>';
        }
        $task->Candidate = $Candidate;
        $task->Autor = $Autor;
        $task->status = $task->getStatus();


        return response(array('success' => "true", 'task' => $task), 200);
    }

    public function getUnfinished(){
        $tasks = Task::where('status', 1)->where('to_user_id', Auth::user()->id)->count();
        return response(array('success' => "true", 'count' => $tasks), 200);
    }
}
