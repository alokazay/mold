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

class ManagerController extends Controller
{
    public function getIndex()
    {

        $invite_link = url('/') . '/manager/invite/' . $this->encodeLink();
        return view('manager.dashboard')->with('invite_link', $invite_link);
    }

    public function getInvite($id)
    {
        $res = $this->decodeLink($id);
        if ($res == '') {
            echo 'Ссылка больше не существует!';
            return '';
        }
        return view('manager.invite_freelancer')->with('rec_id', $res->id);
    }


    private function decodeLink($hash)
    {
        $clean = strtr($hash, ' ', '+');
        $ascii = base64_decode($clean);
        $res = explode('&', $ascii);
        if (array_key_exists(0, $res) && array_key_exists(1, $res)) {

            $valid_hash = md5(Carbon::now()->format('d.m.Y') . $res[0] . 'pasSwrd');
            if ($valid_hash != $res[1]) {
                return '';
            }

            $recrutier = User::find($res[0]);
            return $recrutier;
        } else {
            return '';
        }
    }

    private function encodeLink()
    {
        $hash = Auth::user()->id . '&' . md5(Carbon::now()->format('d.m.Y') . Auth::user()->id . 'pasSwrd');
        $hash = base64_encode($hash);
        return $hash;
    }

    public function getInviteAdd(Request $r)
    {



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


        $user = new User();
        $user->group_id = 3;
        $user->activation = 1;
        $user->fl_status = 1;
        $user->manager_id = $r->manager_id;
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
        $user->password = Hash::make($r->password);
        $user->remember_token = Hash::make($user->password);

        $user->save();

        Auth::loginUsingId($user->id);

        return response(array('success' => "true"), 200);

    }

}
