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

class UsersController extends Controller
{
    public function getIndex()
    {
        return view('users.index');
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
        $filter__status = request('status');
        $search = request('search');
        $group = request('group');


        if ($filter__status == '') {
            $users = User::whereIn('activation', [1]);
        } else {
            $users = User::where('activation', $filter__status);
        }

        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('firstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%');
            });
        }

        if ($group != '') {
            $users = $users->where('group_id', $group);
        }


        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('D_file')
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

            if ($u->activation == 1) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                <option selected value="1">Активный</option>
                                <option value="2">Не активный</option>
                            </select>';
            } else {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                <option value="1">Активный</option>
                                <option selected value="2">Не активный</option>
                            </select>';
            }


            $temp_arr = [
                //  $checkbox,
                '<a href="javascript:;" onclick="editUser(' . $u->id . ')">' . $u->id . '</a>',
                $u->firstName,
                $u->lastName,
                $u->getGroup(),
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

    public function addUser(Request $r)
    {
        $user = User::find($r->id);
        if ($user == null) {
            $user = new User();

            $validator = Validator::make($r->all(), [
                'password' => ['required', Password::min(10)],
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }

        } else {
             $validator = Validator::make($r->all(), [
                'email' => 'required|email:rfc,dns|unique:users,email,'.$user->id,
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }
        }
        $user->email = $r->email;
        $user->group_id = $r->group_id;
        $user->activation = $r->activation;
        if ($r->has('firstName')) {
            $user->firstName = $r->firstName;
        }
        if ($r->has('lastName')) {
            $user->lastName = $r->lastName;
        }
        if ($r->has('phone')) {
            $user->phone = $r->phone;
        }
        if ($r->has('account')) {
            $user->account = $r->account;
        }


        if ($r->has('password') && $r->password != '') {
            $user->password = Hash::make($r->password);
            $user->remember_token = Hash::make($user->password);
        }

        $user->save();
        return response(array('success' => "true"), 200);
    }

    public function addFlUser(Request $r)
    {


        $user = User::find($r->id);
        if ($user == null) {


            $user = new User();
            $user->group_id = 3;
            $user->activation = 1;
            $user->fl_status = 1;
            $user->recruter_id = Auth::user()->id;

            $validator = Validator::make($r->all(), [
                'password' => ['required', Password::min(10)],
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }

        } else {
            $validator = Validator::make($r->all(), [
                'email' => 'required|email:rfc,dns|unique:users,email,'.$user->id,
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response(array('success' => "false", 'error' => $error), 200);
            }

            if(Auth::user()->isAdmin()){
                $user->recruter_id = $r->recruter_id;
            }
        }
        $user->email = $r->email;
        $user->firstName = $r->firstName;
        $user->lastName = $r->lastName;
        $user->phone = $r->phone;
        $user->viber = $r->viber;
        $user->facebook = $r->facebook;
        $user->account_type = $r->account_type;
        $user->account_poland = $r->account_poland;
        $user->account_paypal = $r->account_paypal;
        $user->account_bank_name = $r->account_bank_name;
        $user->account_iban = $r->account_iban;
        $user->account_card = $r->account_card;
        $user->account_swift = $r->account_swift;



        if ($r->has('password') && $r->password != '') {
            $user->password = Hash::make($r->password);
            $user->remember_token = Hash::make($user->password);
        }

        $user->save();
        return response(array('success' => "true"), 200);
    }

    public function postProfile(Request $r)
    {


        $user = User::where('id', Auth::user()->id)->first();

        $validator = Validator::make($r->all(), [
            'email' => 'required|email:rfc,dns|unique:users,email,'.$user->id,
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response(array('success' => "false", 'error' => $error), 200);
        }

        $user->email = $r->email;
        $user->firstName = $r->firstName;
        $user->lastName = $r->lastName;
        $user->phone = $r->phone;

        if ($r->has('password') && $r->password != '') {
            $user->password = Hash::make($r->password);
            $user->remember_token = Hash::make($user->password);
        }

        $user->save();
        return response(array('success' => "true"), 200);
    }

    public function filesUserAdd()
    {

        $user_id = request()->get('user_id');
        if ($user_id == '') {
            $user = new User();
            $user->email = Str::random(12) . '@test.com';
            $user->group_id = 1;
            $user->activation = 2;
            $user->save();
            $user_id = $user->id;
        } else {
            $C_files = C_file::where('user_id', $user_id)->where('type', 1)->get();
            foreach ($C_files as $C_file) {
                unlink(public_path() . $C_file->path);
                C_file::where('id', $C_file->id)->delete();
            }

        }

        $file = request()->file('file');
        if ($file->isValid()) {

            $path = '/uploads/users/' . Carbon::now()->format('m.Y') . '/' . $user_id . '/files/';
            $name = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($path), $name);
            $file_link = $path . $name;


            $file = new C_file();
            $file->autor_id = Auth::user()->id;
            $file->user_id = $user_id;
            $file->type = 1;
            $file->original_name = request()->file('file')->getClientOriginalName();
            $file->ext = request()->file('file')->getClientOriginalExtension();
            $file->path = $file_link;
            $file->save();

            return Response::json(array('success' => "true",
                'user_id' => $user_id,
                'path' => $file_link
            ), 200);

        }
    }

    public function getUserAjax($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return response(array('success' => "false", 'error' => 'Пользователь не найден!'), 200);
        }

        return response(array('success' => "true", 'user' => $user), 200);
    }

    public function usersActivation(Request $r)
    {
        User::where('id', $r->id)->update(['activation' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    function authBy($id)
    {
        Auth::loginUsingId($id);
        return Redirect::to(url('/') . '/dashboard');
    }

    public function getProfile()
    {
        return view('users.profile.index');
    }
}
