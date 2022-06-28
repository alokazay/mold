<?php

namespace App\Http\Controllers;

use App\Models\Account_firm;
use App\Models\C_file;
use App\Models\Finance;
use App\Models\Handbook;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class FinanceController extends Controller
{
    public function getIndex()
    {

        return view('freelansers.requests.index');
    }

    public function getJson()
    {

        $firms = Account_firm::where('active', 1)->get();

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

        if ($status == '') {
            $users = Finance::whereIn('status', [1, 2]);
        } else {
            $users = Finance::where('status', $status);
        }

        if (Auth::user()->isFreelancer()) {
            $users = $users->where('user_id', Auth::user()->id);
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('User')
            ->with('D_file')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {

            if ($u->date_payed != '') {
                $date_payed = Carbon::parse($u->date_payed)->format('d.m.Y');
            } else {
                $date_payed = '';
            }


            if (Auth::user()->isAccountant()) {


                if ($u->D_file != null) {
                    $file = '<a   href="javascript:;"><i data-id="' . $u->id . '" id="file_' . $u->id . '"  class="fa fa-pen add_file"></i></a>';
                    $file .= '<a target="_blank" href="' . url('/') . $u->D_file->path . '" style="cursor: pointer;" class="svg-icon svg-icon-2x svg-icon-primary me-4">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
																	<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
																</svg>
															</a>';
                } else {
                    $file = '<a data-id="' . $u->id . '" id="file_' . $u->id . '" class="add_file" href="javascript:;">загрузить</a>';
                }

            } else {

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
            }

            if (Auth::user()->isFreelancer()) {
                $temp_arr = [
                    $u->id,
                    Carbon::parse($u->date_request)->format('d.m.Y'),
                    $u->amount,
                    $date_payed,
                    $u->getStatus(),
                    $file
                ];
            } else {

                $select_active = '<select onchange="changeStatus(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeStatus' . $u->id . '">
                                             ' . $u->getStatusOptions() . '
                            </select>';


                $firms_select = '<select onchange="changeFirm(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeFirm' . $u->id . '">';
                foreach ($firms as $firm) {
                    $selected = '';
                    if ($firm->id == $u->firm_id) $selected = 'selected';
                    $firms_select .= '<option ' . $selected . ' value="' . $firm->id . '">' . $firm->name . '</option>';
                }
                $firms_select .= '</select>';


                $temp_arr = [
                    $u->id,
                    $u->user->firstName,
                    $u->user->lastName,
                    $u->user->phone,
                    'счет',
                    Carbon::parse($u->date_request)->format('d.m.Y'),
                    $u->amount,
                    $firms_select,
                    $select_active,
                    $file
                ];
            }

            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => Finance::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function postAdd(Request $r)
    {

        if (Auth::user()->isAccountant()) {
            $user = User::find($r->user_id);
        } else {
            $user = User::find(Auth::user()->id);
        }


        if (($user->balance) < $r->amount) {
            return response(array('success' => "false", 'error' => 'Сумма для вывода не доступна'), 200);
        }

        $f = new Finance();
        $f->amount = $r->amount;
        if (Auth::user()->isAccountant()) {
            $f->user_id = $r->user_id;
        } else {
            $f->user_id = Auth::user()->id;
        }

        $f->status = 1;
        $f->date_request = Carbon::now();
        $f->type_request_id = $r->type_request_id;
        $f->save();

        if (Auth::user()->isAccountant()) {
            $user = User::find($r->user_id);
        } else {
            $user = User::find(Auth::user()->id);
        }

        $user->balance = Auth::user()->balance - $f->amount;
        $user->save();

        return response(array('success' => "true", 'amount' => $user->balance), 200);
    }

    public function postRequestsChangeStatus(Request $r)
    {
        $finance = Finance::find($r->id);

        if ($finance != null) {

            if($r->s == 2){
                if($finance->file_id == null || $finance->file_id == ''){
                    return response(array('success' => "false" , 'error' => 'Загрузите подтверждающий документ'), 200);
                }
            }

            if ($finance->status == 2) {
                return response(array('success' => "false" , 'error' => 'Понизить статус нельзя'), 200);
            }

            $finance->status = $r->s;
            $finance->save();
        }

        return response(array('success' => "true"), 200);
    }

    public function postRequestsChangeFirm(Request $r)
    {
        Finance::where('id', $r->id)->update(['firm_id' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function addSuccessPaymentDoc()
    {
        $r_id = request()->get('id');
        $file = request()->file('file');
        if ($file->isValid()) {

            $path = '/uploads/request/' . Carbon::now()->format('m.Y') . '/' . $r_id . '/files/';
            $name = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($path), $name);
            $file_link = $path . $name;


            $file = new C_file();
            $file->autor_id = Auth::user()->id;
            $file->user_id = Auth::user()->id;
            $file->type = 5;
            $file->original_name = request()->file('file')->getClientOriginalName();
            $file->ext = request()->file('file')->getClientOriginalExtension();
            $file->path = $file_link;
            $file->save();

            $finance = Finance::find($r_id);
            $finance->file_id = $file->id;
            $finance->date_payed = Carbon::now();
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
