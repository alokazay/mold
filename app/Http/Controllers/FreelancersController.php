<?php

namespace App\Http\Controllers;

use App\Models\C_file;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class FreelancersController extends Controller
{
    public function getIndex()
    {
        $recruters = User::where('group_id',2)->where('activation',1)->get();
        return view('freelansers.index')->with('recruters',$recruters);
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
        $fl_status = request('fl_status');
        $search = request('search');


        $users = User::where('activation', 1);
        $users = $users->where('group_id', 3);

        if ($fl_status == '') {
            $users = $users->whereIn('fl_status', [1, 2, 3, 4]);
        } else {
            $users = $users->where('fl_status', $fl_status);
        }

        if (Auth::user()->isRecruter()) {
            $users = $users->where('recruter_id', Auth::user()->id);
        }

        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('D_file')
            ->with('Recruter')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];

        $checkbox = '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" value="1">
                                                </div>';


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

            if (Auth::user()->group_id == 1 || Auth::user()->group_id == 2) {
                if ($u->fl_status == 1 || $u->fl_status == '') {
                    $select_active = '<select onchange="changeFl_status(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                    <option selected value="1">Новый</option>
                                            <option value="2">Верифицирован</option>
                                            <option value="3">Отклонён</option>
                                            <option value="4">Уволен</option>
                            </select>';
                } else if ($u->fl_status == 2) {
                    $select_active = '<select onchange="changeFl_status(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                    <option  value="1">Новый</option>
                                            <option selected value="2">Верифицирован</option>
                                            <option  value="3">Отклонён</option>
                                            <option value="4">Уволен</option>
                            </select>';
                } else if ($u->fl_status == 3) {
                    $select_active = '<select onchange="changeFl_status(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                    <option   value="1">Новый</option>
                                            <option value="2">Верифицирован</option>
                                            <option selected value="3">Отклонён</option>
                                            <option value="4">Уволен</option>
                            </select>';
                } else if ($u->fl_status == 4) {
                    $select_active = '<select onchange="changeFl_status(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                    <option   value="1">Новый</option>
                                            <option value="2">Верифицирован</option>
                                            <option value="3">Отклонён</option>
                                            <option selected value="4">Уволен</option>
                            </select>';
                }
            } else {
                $select_active = $u->getFl_status();
            }


            $Recruter = '';
            if ($u->Recruter != null) {
                $Recruter = $u->Recruter->firstName . ' ' . $u->Recruter->lastName;
            }

            $temp_arr = [
                //  $checkbox,
                '<a href="javascript:;" onclick="editUser(' . $u->id . ')">' . $u->id . '</a>',
                $u->firstName,
                $u->lastName,
                $Recruter,
                $u->phone,
                $u->email,
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
        User::where('id', $r->id)->update(['fl_status' => $r->s]);
        return response(array('success' => "true"), 200);
    }

}
