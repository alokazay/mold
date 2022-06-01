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

class RecruiterController extends Controller
{
    public function getIndex()
    {

        $invite_link = url('/') . '/recruiter/invite/' . $this->encodeLink();
        return view('recruiter.dashboard')->with('invite_link', $invite_link);
    }

    public function getInvite($id)
    {
        echo $this->decodeLink($id);

    }


    private function decodeLink($hash)
    {
        $clean = strtr($hash, ' ', '+');
        $ascii = base64_decode($clean);
        $res = explode('&', $ascii);
        if (array_key_exists(0, $res) && array_key_exists(1, $res)) {

            $valid_hash = md5(Carbon::now()->format('d.m.Y')  . Auth::user()->id . 'pasSwrd');
            if ($valid_hash != $res[1]) {
                echo 'Ссылка больше не существует!';
                return '';
            }

            $recrutier = User::find($res[0]);
            echo 'Рекрутер: ' . $recrutier->firstName . ' ' . $recrutier->lastName;
            return '';
        } else {
            echo 'Ссылка больше не существует!';
            return '';
        }
    }

    private function encodeLink()
    {
        $hash = Auth::user()->id . '&' . md5(Carbon::now()->format('d.m.Y') . Auth::user()->id . 'pasSwrd');
        $hash = base64_encode($hash);
        return $hash;
    }


}
