<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\Candidate_arrival;
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
        if ($params == 'Candidate' || $params == 'Candidate.setStatus') {
            
            $candidate = $this->getCandidate($request->id);

            if ($candidate) {
                $user_id = Auth::user()->id;
                $user_role = Auth::user()->group_id;

                if ($params == 'Candidate.setStatus') {
                    $mutated = new FieldsMutation;
        
                    $mutated->user_id = $user_id;
                    $mutated->user_role = $user_role;
                    $mutated->model_name = 'Candidate';
                    $mutated->model_obj_id = $request->id;
                    $mutated->field_name = 'active';
                    $mutated->prev_value = $candidate['active'];
                    $mutated->current_value = $request->s;

                    $mutated->save();

                    if ($request->r) {
                        $mutated = new FieldsMutation;
        
                        $mutated->user_id = $user_id;
                        $mutated->user_role = $user_role;
                        $mutated->model_name = 'Candidate';
                        $mutated->model_obj_id = $request->id;
                        $mutated->field_name = 'reason_reject';
                        $mutated->prev_value = $candidate['reason_reject'];
                        $mutated->current_value = $request->r;

                        $mutated->save();
                    }

                } else {
                    foreach ($request->all() as $key => $value) {
                        if (array_key_exists($key, $candidate) && $value != $candidate[$key]) {
        
                            $mutated = new FieldsMutation;
        
                            $mutated->user_id = $user_id;
                            $mutated->user_role = $user_role;
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

        } elseif ($params == 'CandidateArrival' || $params == 'CandidateArrival.setStatus') {
            
            $arrival = $this->getArrival($request->id);

            if ($arrival) {
                $user_id = Auth::user()->id;
                $user_role = Auth::user()->group_id;

                if ($params == 'CandidateArrival.setStatus') {
                    $mutated = new FieldsMutation;

                    $mutated->user_id = $user_id;
                    $mutated->user_role = $user_role;
                    $mutated->model_name = 'CandidateArrival';
                    $mutated->model_obj_id = $request->id;
                    $mutated->parent_model_id = $arrival['candidate_id'];
                    $mutated->field_name = 'status';
                    $mutated->prev_value = $arrival['status'];
                    $mutated->current_value = $request->s;

                    $mutated->save();
                } else {
                    foreach ($request->all() as $key => $value) {
                        if (array_key_exists($key, $arrival) && $value != $arrival[$key]) {
        
                            $mutated = new FieldsMutation;
        
                            $mutated->user_id = $user_id;
                            $mutated->user_role = $user_role;
                            $mutated->model_name = 'CandidateArrival';
                            $mutated->model_obj_id = $request->id;
                            $mutated->parent_model_id = $request->candidate_id;
                            $mutated->field_name = $key;
                            $mutated->prev_value = $arrival[$key];
                            $mutated->current_value = $value;
        
                            $mutated->save();
                        }
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

    private function getArrival($id)
    {
        $arrival = Candidate_arrival::find($id);

        if (!$arrival) {
            return null;
        }

        $result = array();

        foreach ($arrival->toArray() as $key => $value) {
            if ($key == 'date_arrive') {
                $result[$key] = $value ? Carbon::parse($value)->format('d.m.Y H:i') : null;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
