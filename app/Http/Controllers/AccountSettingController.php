<?php

namespace App\Http\Controllers;

use App\Models\Account_setting;
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{
    public function getProfile()
    {
        $acc = Account_setting::find(1);
        return view('accountant.profile')->with('acc',$acc);
    }

    public function postProfileSave(Request $r)
    {
        $acc = Account_setting::find(1);
        $acc->nip = $r->nip;
        $acc->name1 = $r->name1;
        $acc->name2 = $r->name2;
        $acc->save();

        return response(array('success' => "true"), 200);
    }
}
