<?php

namespace App\Http\Controllers;

use App\Models\C_file;
use App\Models\Vacancy_client;
use App\Models\Handbook;
use App\Models\Handbook_vacancy;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Builder;

class VacancyController extends Controller
{
    public function getIndex()
    {
        $industries = Handbook::where('handbook_category_id', 1)->where('active', 1)->get();
        $cities = Handbook::where('handbook_category_id', 3)->where('active', 1)->get();
        return view('vacancies.index')
            ->with('cities', $cities)
            ->with('industries', $industries);
    }

    public function getAdd(Request $r)
    {
        if ($r->has('id')) {
            $h_v_industry = [];
            $h_v_nacionality = [];
            $h_v_city = [];
            $Clients = [];
            $Doc = [];
            $vacancy = Vacancy::where('id', $r->id)
                ->with('h_v_industry')
                ->with('h_v_industry.Handbooks')
                ->with('h_v_nacionality')
                ->with('h_v_nacionality.Handbooks')
                ->with('h_v_city')
                ->with('h_v_city.Handbooks')
                ->with('Vacancy_client')
                ->with('Vacancy_client.Client')
                ->with('Doc')
                ->first();

            foreach ($vacancy->h_v_industry as $industry) {
                if ($industry->Handbooks != null) {
                    $h_v_industry[] = [$industry->Handbooks->id, $industry->Handbooks->name];
                }
            }
            foreach ($vacancy->h_v_nacionality as $industry) {
                if ($industry->Handbooks != null) {
                    $h_v_nacionality[] = [$industry->Handbooks->id, $industry->Handbooks->name];
                }
            }
            foreach ($vacancy->h_v_city as $industry) {
                if ($industry->Handbooks != null) {
                    $h_v_city[] = [$industry->Handbooks->id, $industry->Handbooks->name];
                }
            }
            foreach ($vacancy->Vacancy_client as $industry) {
                if ($industry->Client != null) {
                    $Clients[] = [$industry->Client->id, $industry->Client->name];
                }
            }


            if ($vacancy->Doc != null) {
                $Doc = [$vacancy->Doc->id, $vacancy->Doc->name];
            }

        } else {
            $vacancy = null;
            $h_v_industry = null;
            $h_v_nacionality = null;
            $h_v_city = null;
            $Clients = null;
            $Doc = null;

        }
        return view('vacancies.add')
            ->with('h_v_city', $h_v_city)
            ->with('h_v_nacionality', $h_v_nacionality)
            ->with('h_v_industry', $h_v_industry)
            ->with('Clients', $Clients)
            ->with('Doc', $Doc)
            ->with('vacancy', $vacancy);
    }

    public function filesAdd()
    {

        $vacancy_id = request()->get('vacancy_id');
        if ($vacancy_id == '') {
            $vacancy = new Vacancy();
            $vacancy->title = '';
            $vacancy->user_id = Auth::user()->id;
            $vacancy->save();
            $vacancy_id = $vacancy->id;
        }

        $file = request()->file('file');
        if ($file->isValid()) {

            $path = '/uploads/vacancies/' . Carbon::now()->format('m.Y') . '/' . $vacancy_id . '/files/';
            $name = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path($path), $name);
            $file_link = $path . $name;


            $file = new C_file();
            $file->autor_id = Auth::user()->id;
            $file->vacancy_id = $vacancy_id;
            $file->user_id = Auth::user()->id;
            $file->type = 2;
            $file->original_name = request()->file('file')->getClientOriginalName();
            $file->ext = request()->file('file')->getClientOriginalExtension();
            $file->path = $file_link;
            $file->save();

            return Response::json(array('success' => "true",
                'vacancy_id' => $vacancy_id,
                'path' => url('/') . '' . $file_link
            ), 200);
        } else {
            return Response::json(array('success' => "false",
                'error' => 'file not valid!'
            ), 200);
        }
    }

    public function postAdd(Request $r)
    {

        $niceNames = [
            'title' => '«название»',
            'description' => '«описание»',
            'client_id' => '«клиент»',
            'deadline_from' => '«дедлайн с»',
            'deadline_to' => '«дедлайн по»',
            'salary' => '«ставка»',
            'salary_description' => '«ставка описание»',
            'count_hours' => '«часов»',
            'doc_id' => '«документ»',
            'housing_cost' => '«стоимость жилья»',
            'housing_description' => '«описание жилья»',
            'housing_people' => '«кол-во людей в комнате»',
            'industry_id' => '«отрасль»',
            'nationality_id' => '«национальность»',
            'work_place_id' => '«место работы»',
        ];
        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'description' => 'required',
            'client_id' => 'required',
            'deadline_from' => 'required',
            'deadline_to' => 'required',
            'salary' => 'required|numeric',
            'salary_description' => 'required',
            'count_hours' => 'required|numeric',
            'doc_id' => 'required',
            'housing_cost' => 'required|numeric',
            'housing_people' => 'required',
            'housing_description' => 'required',
            'industry_id' => 'required',
            'nationality_id' => 'required',
            'work_place_id' => 'required',
        ], [], $niceNames);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response(array('success' => "false", 'error' => $error), 200);
        }

        $vacancy = Vacancy::find($r->id);
        if ($vacancy == null) {
            $vacancy = new Vacancy();
            $vacancy->activation = 1;
        }


        $vacancy->title = $r->title;
        $vacancy->description = $r->description;
        $vacancy->count_men = $r->count_men;
        $vacancy->count_women = $r->count_women;
        $vacancy->count_people = $r->count_people;
        $vacancy->salary = $r->salary;
        $vacancy->salary_description = $r->salary_description;
        $vacancy->count_hours = $r->count_hours;
        $vacancy->doc_id = $r->doc_id;
        $vacancy->housing_cost = $r->housing_cost;
        $vacancy->housing_people = $r->housing_people;
        $vacancy->housing_description = $r->housing_description;
        $vacancy->user_id = Auth::user()->id;
        $vacancy->deadline_from = Carbon::createFromFormat('d.m.Y', $r->deadline_from);
        $vacancy->deadline_to = Carbon::createFromFormat('d.m.Y', $r->deadline_to);

        if (!Auth::user()->isRecruter()) {
            $vacancy->recruting_cost = $r->recruting_cost;
            $vacancy->cost_pay_lead = $r->cost_pay_lead;
        } else {
            if ($vacancy->recruting_cost == '' || $vacancy->cost_pay_lead == '') {
                return response(array('success' => "false", 'error' => 'Заполните стоимость'), 200);
            }
        }

        $vacancy->save();


        Handbook_vacancy::where('vacancy_id', $vacancy->id)->delete();
        $arrs = explode(',', $r->industry_id);
        foreach ($arrs as $arr) {
            $Hand = new Handbook_vacancy();
            $Hand->vacancy_id = $vacancy->id;
            $Hand->handbook_id = $arr;
            $Hand->handbook_category_id = 1;
            $Hand->save();
        }
        $arrs = explode(',', $r->nationality_id);
        foreach ($arrs as $arr) {
            $Hand = new Handbook_vacancy();
            $Hand->vacancy_id = $vacancy->id;
            $Hand->handbook_id = $arr;
            $Hand->handbook_category_id = 2;
            $Hand->save();
        }
        $arrs = explode(',', $r->work_place_id);
        foreach ($arrs as $arr) {
            $Hand = new Handbook_vacancy();
            $Hand->vacancy_id = $vacancy->id;
            $Hand->handbook_id = $arr;
            $Hand->handbook_category_id = 3;
            $Hand->save();
        }

        Vacancy_client::where('vacancy_id', $vacancy->id)->delete();
        $arrs = explode(',', $r->client_id);
        foreach ($arrs as $arr) {
            $Hand = new Vacancy_client();
            $Hand->vacancy_id = $vacancy->id;
            $Hand->client_id = $arr;
            $Hand->save();
        }


        return Response::json(array('success' => "true", 200));
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

                if ($data == 2) {
                    $order_col = 'deadline_to';
                }

            }
        }
        // search
        $filter__status = request('status');
        $filter__industry = request('industry');
        $filter__city = request('city');
        $filter__genre = request('genre');
        $search = request('search');


        if ($filter__status == '') {
            $users = Vacancy::whereIn('activation', [1, 2, 3]);
        } else {
            $users = Vacancy::where('activation', $filter__status);
        }

        if (Auth::user()->isFreelancer() || Auth::user()->isRecruter()) {
            $users = Vacancy::whereIn('activation', [1]);
        }


        // Фрилансеры видят только свои

        if ($filter__industry != '') {
            $users = $users->whereHas('h_v_industry', function (Builder $query) use ($filter__industry) {
                $query->where('handbook_id', $filter__industry);
            });
        }

        if ($filter__city != '') {
            $users = $users->whereHas('h_v_city', function (Builder $query) use ($filter__city) {
                $query->where('handbook_id', $filter__city);
            });
        }
        if ($filter__genre == '1') {
            $users = $users->where('count_men', '>', 0);
        }
        if ($filter__genre == '2') {
            $users = $users->where('count_women', '>', 0);
        }
        if ($filter__genre == '3') {
            $users = $users->where('count_people', '>', 0);
        }

        if ($search != '') {
            $users = $users->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        /*  if ($group != '') {
              $users = $users->where('group_id', $group);
          }*/


        $users = $users->orderBy($order_col, $order_direction);


        $users = $users
            ->with('h_v_industry')
            ->with('h_v_city')
            ->with('h_v_industry.Handbooks')
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

            if ($u->activation == 1) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                <option selected value="1">Активный</option>
                                <option value="2">Пауза</option>
                                <option value="3">Завершена</option>
                                <option value="4">Удалена</option>
                            </select>';
            } else if ($u->activation == 2) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                 <option value="1">Активный</option>
                                <option selected value="2">Пауза</option>
                                <option value="3">Завершена</option>
                                <option value="4">Удалена</option>
                            </select>';
            } else if ($u->activation == 3) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                 <option value="1">Активный</option>
                                <option   value="2">Пауза</option>
                                <option selected value="3">Завершена</option>
                                <option value="4">Удалена</option>
                            </select>';
            } else if ($u->activation == 4) {
                $select_active = '<select onchange="changeActivation(' . $u->id . ')"
                                    class="form-select form-select-sm form-select-solid changeActivation' . $u->id . '">
                                 <option value="1">Активный</option>
                                <option   value="2">Пауза</option>
                                <option   value="3">Завершена</option>
                                <option selected value="4">Удалена</option>
                            </select>';
            }

            $recruting_cost = '<input  onchange="changeCost(' . $u->id . ')" class="w-55px changeCost' . $u->id . '" value="' . $u->recruting_cost . '" style="border: none;" type="text">';
            $recruting_cost_pay_lead = '<input  onchange="changeCost_pay_lead(' . $u->id . ')" class="w-55px changeCost_pay_lead' . $u->id . '" value="' . $u->cost_pay_lead . '" style="border: none;" type="text">';
            $recruting_housing_cost = '<input  onchange="change_housing_cost(' . $u->id . ')" class="w-45px change_housing_cost' . $u->id . '" value="' . $u->housing_cost . '" style="border: none;" type="text">';
            $recruting_count_men = '<input  onchange="change_count_men(' . $u->id . ')" class="w-30px change_count_men' . $u->id . '" value="' . $u->count_men . '" style="border: none;" type="text">';
            $recruting_count_women = '<input  onchange="change_count_women(' . $u->id . ')" class="w-30px change_count_women' . $u->id . '" value="' . $u->count_women . '" style="border: none;" type="text">';
            $recruting_count_people = '<input  onchange="change_count_people(' . $u->id . ')" class="w-30px change_count_people' . $u->id . '" value="' . $u->count_people . '" style="border: none;" type="text">';
            $recruting_salary = '<input  onchange="change_salary(' . $u->id . ')" class="w-45px change_salary' . $u->id . '" value="' . $u->salary . '" style="border: none;" type="text">';
            if (Auth::user()->isRecruter() || Auth::user()->isFreelancer()) {


                if (Auth::user()->isRecruter()) {
                    $add_link = '<a href="' . url('/') . '/candidate/add?r_id=' . Auth::user()->id . '&vid=' . $u->id . '"><i class="fas fa-user-plus"></i></a>';
                }

                if (Auth::user()->isFreelancer()) {
                    if (Auth::user()->fl_status == 2) {
                        $add_link = '<a href="' . url('/') . '/candidate/add?r_id=' . Auth::user()->recruter_id . '&vid=' . $u->id . '"><i class="fas fa-user-plus"></i></a>';
                    } else {
                        $add_link = '';
                    }
                }


                $count_men = '';
                $count_women = '';
                $count_people = '';

                if (Auth::user()->isFreelancer() || Auth::user()->isRecruter()) {
                    if ($u->count_men > 0) $count_men = 'М';
                    if ($u->count_women > 0) $count_women = 'Ж';
                    if ($u->count_people > 0) $count_people = 'Н';
                } else {
                    $count_men = $u->count_men;
                    $count_women = $u->count_women;
                    $count_people = $u->count_people;
                }


                // Только фрилансер
                $temp_arr = [
                    '<a href="vacancy/add?id=' . $u->id . '">' . $u->id . '</a>',
                    $u->title,
                    $h_v_industry,
                    Carbon::parse($u->deadline_to)->format('d.m.Y'),
                    $count_men,
                    $count_women,
                    $count_people,
                    $u->salary,
                    $u->salary_description,
                    $u->housing_cost,
                    $add_link
                ];
            } else {
                $temp_arr = [
                    '<a href="vacancy/add?id=' . $u->id . '">' . $u->id . '</a>',
                    $u->title,
                    $h_v_industry,
                    Carbon::parse($u->deadline_to)->format('d.m.Y'),
                    $recruting_count_men,
                    $recruting_count_women,
                    $recruting_count_people,
                    $recruting_salary,
                    $u->salary_description,
                    $recruting_housing_cost,
                    $recruting_cost_pay_lead,
                    $recruting_cost,
                    $select_active
                ];
            }

            $data[] = $temp_arr;
        }


        return Response::json(array('data' => $data,
            "draw" => $draw,
            "recordsTotal" => Vacancy::count(),
            "recordsFiltered" => count($users),
        ), 200);
    }

    public function vacancyActivation(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['activation' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancyChangecost(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['recruting_cost' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancyChangecostpaylead(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['cost_pay_lead' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancyChangehousingcost(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['housing_cost' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancySalary(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['salary' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancyCountpeople(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['count_people' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancyCountwomen(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['count_women' => $r->s]);
        return response(array('success' => "true"), 200);
    }

    public function vacancyCountmen(Request $r)
    {
        Vacancy::where('id', $r->id)->update(['count_men' => $r->s]);
        return response(array('success' => "true"), 200);
    }

}
