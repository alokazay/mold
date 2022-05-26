<?php

namespace App\Http\Controllers;

use App\Models\Client_contact;
use App\Models\Handbook_category;
use App\Models\User;
use App\Models\Client;
use App\Models\Handbook;
use App\Models\Handbook_client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class HandbookController extends Controller
{
    public function getIndex()
    {
        $Handbook_category = Handbook_category::where('active', 1)
            ->with('Handbooks')->get();
        return view('handbooks.index')->with('Handbook_category', $Handbook_category);
    }


    public function deleteHandbook(Request $r)
    {
        Handbook::where('id', $r->id)->update(['active' => 2]);
        return response(array('success' => "true"), 200);
    }

    public function addHandbook(Request $r)
    {
        $Handbook = new Handbook();
        $Handbook->handbook_category_id = $r->cat_id;
        $Handbook->name = $r->name;
        $Handbook->active = 1;
        $Handbook->save();

        return response(array('success' => "true"), 200);
    }


}
