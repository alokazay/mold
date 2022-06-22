<?php

namespace App\Http\Controllers;

use App\Models\Client_contact;
use App\Models\User;
use App\Models\Client;
use App\Models\Handbook;
use App\Models\Handbook_client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function getIndex()
    {
        $industries = Handbook::where('handbook_category_id', 1)->where('active',1)->get();
        return view('clients.index')->with('industries', $industries);
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
        $coordinator_id = request('coordinator_id');
        $industry_id = request('industry_id');


        if ($status == '') {
            $users = Client::whereIn('active', [1]);
        } else {
            $users = Client::where('active', $status);
        }

        if ($coordinator_id != '') {
            $users = $users->where('coordinator_id', $coordinator_id);
        }

        if ($industry_id != '') {
            $ids_h = Handbook_client::where('handbook_id', $industry_id)->pluck('client_id');
            $users = $users->whereIn('id', $ids_h);
        }

        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('h_v_industry')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = [];


        foreach ($users as $u) {


            $h_v_industry = '';
            foreach ($u->h_v_industry as $one) {
                if ($one->Handbooks != null) {
                    $h_v_industry .= $one->Handbooks->name . ' ';
                }
            }


            if ($u->active == 1 || $u->active == '') {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                         <option  selected value="1">Активный</option>
                                            <option value="2">Деактивированный</option>
                            </select>';
            } else if ($u->active == 2) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                         <option value="1">Активный</option>
                                            <option selected value="2">Деактивированный</option>
                            </select>';
            }

            $Coordinator = '';
            if ($u->Coordinator != null) {
                $Coordinator = $u->Coordinator->firstName . ' ' . $u->Coordinator->lastName;
            }

            $temp_arr = [
                //  $checkbox,
                '<a href="client/add?id=' . $u->id . '">' . $u->id . '</a>',
                $u->name,
                $h_v_industry,
                $u->address,
                $Coordinator,
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

    public function clientsActivation(Request $r)
    {
        Client::where('id', $r->id)->update(['active' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function getAdd(Request $r)
    {
        if ($r->has('id')) {
            $client = Client::where('id', $r->id)
                ->with('h_v_industry')
                ->with('h_v_industry.Handbooks')
                ->with('h_v_city')
                ->with('h_v_city.Handbooks')
                ->with('h_v_nationality')
                ->with('h_v_nationality.Handbooks')
                ->with('Contacts')
                ->first();
            if ($client->Coordinator != null) {
                $Coordinator = [$client->Coordinator->id, $client->Coordinator->firstName . ' ' . $client->Coordinator->lastName];
            }
            $h_v_industry = [];
            $h_v_city = [];
            $h_v_nationality = [];

            foreach ($client->h_v_industry as $industry) {
                if ($industry->Handbooks != null) {
                    $h_v_industry[] = [$industry->Handbooks->id, $industry->Handbooks->name];
                }
            }
            foreach ($client->h_v_city as $city) {
                if ($city->Handbooks != null) {
                    $h_v_city[] = [$city->Handbooks->id, $city->Handbooks->name];
                }
            }
            foreach ($client->h_v_nationality as $nationality) {
                if ($nationality->Handbooks != null) {
                    $h_v_nationality[] = [$nationality->Handbooks->id, $nationality->Handbooks->name];
                }
            }
        } else {
            $client = null;
            $Coordinator = null;
            $h_v_industry = null;
            $h_v_city = null;
            $h_v_nationality = null;
        }
        return view('clients.add')
            ->with('h_v_nationality', $h_v_nationality)
            ->with('h_v_city', $h_v_city)
            ->with('h_v_industry', $h_v_industry)
            ->with('Coordinator', $Coordinator)
            ->with('client', $client);
    }

    public function postAdd(Request $r)
    {

        $niceNames = [
            'name' => '«имя»',
            'coordinator_id' => '«координатор»',
            'industry_id' => '«отрасль»',
            'work_place_id' => '«место работы»',
            'nationality_id' => '«Национальность»',
            'address' => '«адрес»',
        ];


        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'coordinator_id' => 'required',
            'address' => 'required',
            'work_place_id' => 'required',
            'industry_id' => 'required',
            'nationality_id' => 'required',

        ], [], $niceNames);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response(array('success' => "false", 'error' => $error), 200);
        }

        $client = Client::find($r->id);
        if ($client == null) {
            $client = new Client();
            $client->active = 1;
        }


        $client->name = $r->name;
        $client->coordinator_id = $r->coordinator_id;
        $client->address = $r->address;
        $client->save();

        Handbook_client::where('client_id', $client->id)->delete();

        $arrs = explode(',', $r->industry_id);
        foreach ($arrs as $arr) {
            $Hand = new Handbook_client();
            $Hand->client_id = $client->id;
            $Hand->handbook_id = $arr;
            $Hand->handbook_category_id = 1;
            $Hand->save();
        }
        $arrs = explode(',', $r->work_place_id);
        foreach ($arrs as $arr) {
            $Hand = new Handbook_client();
            $Hand->client_id = $client->id;
            $Hand->handbook_id = $arr;
            $Hand->handbook_category_id = 3;
            $Hand->save();
        }
        $arrs = explode(',', $r->nationality_id);
        foreach ($arrs as $arr) {
            $Hand = new Handbook_client();
            $Hand->client_id = $client->id;
            $Hand->handbook_id = $arr;
            $Hand->handbook_category_id = 2;
            $Hand->save();
        }

        $clients = json_decode($r->clients);
        Client_contact::where('client_id', $client->id)->delete();
        foreach ($clients as $one) {
            $cl = new Client_contact();
            $cl->user_id = Auth::user()->id;
            $cl->client_id = $client->id;
            $cl->firstName = $one[0];
            $cl->lastName = $one[1];
            $cl->position = $one[2];
            $cl->phone = $one[3];
            $cl->email = $one[4];
            $cl->save();
        }


        return Response::json(array('success' => "true", 200));
    }
}
