<?php

namespace App\Http\Controllers;

use App\Models\Account_firm;
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{
    public function getProfile()
    {
        $firms = Account_firm::where('active',1)->get();
        return view('accountant.profile')->with('firms', $firms);
    }

    public function postProfileSave(Request $r)
    {

        if($r->has('id')){
            $acc = Account_firm::find($r->id);
        } else {
            $acc = new Account_firm();
        }

        $acc->nip = $r->nip;
        $acc->name = $r->name;
        $acc->active = 1;
        $acc->save();

        return response(array('success' => "true"), 200);
    }

    public function deleteFirm(Request $r)
    {
        Account_firm::where('id', $r->id)->update(['active' => 2]);
        return response(array('success' => "true"), 200);
    }
}
