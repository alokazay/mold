<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\FieldsMutation;
use Carbon\Carbon;

class FieldsMutationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $params)
    {
        if ($params == 'Candidate') {

            print_r($request->all());

            $candidate = $this->getCandidate($request->id);

            print_r($candidate);

            if ($candidate) {
                foreach ($request->all() as $key => $value) {
                    if (array_key_exists($key, $candidate) && $value != $candidate[$key]) {
    
                        $mutated = new FieldsMutation;
    
                        $mutated->user_id = Auth::user()->id;
                        $mutated->model_name = 'Candidate';
                        $mutated->model_obj_id = $request->id;
                        $mutated->field_name = $key;
                        $mutated->prev_value = $candidate[$key];
                        $mutated->current_value = $value;

                        $mutated->save();
                    }
                }
            }
        }

        return $next($request);
    }

    private function getCandidate($id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return null;
        }

        $result = array();

        foreach ($candidate->toArray() as $key => $value) {
            if (
                $key == 'dateOfBirth'
                || $key == 'date_arrive'
                || $key == 'date_start_work'
            ) {
                $result[$key] = $value ? Carbon::parse($value)->format('d.m.Y') : null;
            } else if (
                $key == 'logist_date_arrive'
            ) {
                $result[$key] = $value ? Carbon::parse($value)->format('d.m.Y H:i') : null;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
