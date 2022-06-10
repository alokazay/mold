<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Handbook;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FinanceController extends Controller
{
    public function getIndex()
    {
        $types = Handbook::where('handbook_category_id', 11)->get();
        return view('freelansers.requests.index')->with('types', $types);
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

        if ($status == '') {
            $users = Finance::whereIn('status', [1, 2]);
        } else {
            $users = Finance::where('status', $status);
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
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


            $temp_arr = [
                $u->id,
                Carbon::parse($u->date_request)->format('d.m.Y'),
                $u->amount,
                $date_payed,
                $u->getStatus(),
                $file

            ];
            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => User::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function postAdd(Request $r)
    {

        if ((Auth::user()->balance) < $r->amount) {
            return response(array('success' => "false", 'error' => 'Сумма для вывода не доступна'), 200);
        }

        $f = new Finance();
        $f->amount = $r->amount;
        $f->user_id = Auth::user()->id;
        $f->status = 1;
        $f->date_request = Carbon::now();
        $f->type_request_id = $r->type_request_id;
        $f->save();

        $user = User::find(Auth::user()->id);
        $user->balance = Auth::user()->balance - $f->amount;
        $user->save();

        return response(array('success' => "true", 'amount' => $user->balance), 200);


    }

}
