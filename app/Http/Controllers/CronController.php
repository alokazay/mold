<?php

namespace App\Http\Controllers;

use App\Models\C_file;
use App\Models\Candidate;
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

class CronController extends Controller
{
    public function setAuto7days()
    {
        $d = Carbon::now()->subDays(10);
        $candidates = Candidate::where('active', 9)
            ->where('date_start_work', '<=', $d)->limit(50)->get();
        foreach ($candidates as $candidate) {
            $candidate->active = 10;
            if ($candidate->is_payed != 1) {
                $user = User::find($candidate->user_id);
                $user->balance = $user->balance + $candidate->cost_pay;
                $user->save();

                $candidate->is_payed = 1;
            }
            $candidate->save();
        }


    }

    public function setDeclineFreelance()
    {
        $d = Carbon::now()->subDays(60);
        $fl = User::where('activation', 1)
            ->where('fl_status', 2)
            ->withCount('Candidates')
            ->having('Candidates_count', '<', 1)
            ->where('created_at', '<=', $d)
            ->update(array('activation' => 2));
    }

}
