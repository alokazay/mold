<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\User;
use App\Models\Handbook_category;
use App\Models\Handbook_client;
use App\Models\Handbook;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function getAjaxVacancyClients()
    {
        $search = request('f_search');

        $Course = Client::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxVacancyNationality()
    {
        $search = request('f_search');

        $ids = Handbook_client::where('client_id', request('client_id'))->pluck('handbook_id');
        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 2)
            ->whereIn('id', $ids)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxVacancyWorkplace()
    {
        $search = request('f_search');
        $ids = Handbook_client::where('client_id', request('client_id'))->pluck('handbook_id');

        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 3)
            ->whereIn('id', $ids)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxVacancyIndustry()
    {
        $search = request('f_search');
        $ids = Handbook_client::where('client_id', request('client_id'))->pluck('handbook_id');

        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 1)
            ->whereIn('id', $ids)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientIndustry()
    {
        $search = request('f_search');

        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 1)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxVacancyDocs()
    {
        $search = request('f_search');

        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 4)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientWorkplace()
    {
        $search = request('f_search');

        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 3)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientCoordinator()
    {
        $search = request('f_search');

        $Course = User::where(function ($query) use ($search) {
            $query->where('firstName', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('lastName', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%');
        })->where('group_id', 6)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->firstName . ' ' . $c->lastName;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxCandidateVacancy()
    {
        $search = request('f_search');

        $Course = Vacancy::where(function ($query) use ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        })->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->title;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientNationality()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 2)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientCitizenship()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 10)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientCountry()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 5)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientTypedocs()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 6)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientPlacearrive()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 8)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientRealstatuswork()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 9)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }

    public function getAjaxClientTransport()
    {
        $search = request('f_search');


        $Course = Handbook::where('name', 'LIKE', '%' . $search . '%')
            ->where('active', 1)
            ->where('handbook_category_id', 7)
            ->take(10)
            ->get();

        $p_temp = [];

        if (count($Course)) {
            foreach ($Course as $c) {
                $p_temp_arr = [];
                $p_temp_arr['value'] = $c->name;
                $p_temp_arr['id'] = $c->id;
                $p_temp[] = $p_temp_arr;
            }
        }

        if (count($Course)) {
            return response($p_temp, 200);
        } else {
            return response(array('success' => "false"), 200);
        }
    }


}
