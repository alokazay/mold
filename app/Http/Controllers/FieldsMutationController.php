<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FieldsMutation;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Candidate;

class FieldsMutationController extends Controller
{
    public function getIndex()
    {
        $users = User::all();
        $candidates = Candidate::all();

        $roles_ids = array(
            "1" => "Администратор",
            "2" => "Рекрутер",
            "3" => "Фрилансер",
            "4" => "Логист",
            "5" => "Трудоустройство",
            "6" => "Координатор",
            "7" => "Бухгалтер",
            "8" => "Менеджер поддержки",
        );

        return view('fields-mutation.index', compact('roles_ids', 'users', 'candidates'));
    }

    public function getJson(Request $request)
    {
        $data = FieldsMutation::when($request->period, function ($query, $period) {
                if ($period == 'today') {
                    return $query->whereDate('created_at', Carbon::now());
                } elseif ($period == 'yesterday') {
                    return $query->whereDate('created_at', Carbon::now()->subDays(1));
                } elseif ($period == 'lastWeek') {
                    return $query->whereDate('created_at', '>', Carbon::now()->subDays(7));
                } elseif ($period == 'lastMonth') {
                    return $query->whereDate('created_at', '>', Carbon::now()->subDays(30));
                }
            })
            ->when($request->roles, function ($query, $role) {
                return $query->where('user_role', $role);
            })
            ->when($request->candidate_id, function ($query, $candidate_id) {
                return $query->where('model_obj_id', $candidate_id)
                    ->orWhere('parent_model_id', $candidate_id);
            })
            ->when($request->user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        $result = array();

        foreach ($data as $item) {
            $item['date_time'] = Carbon::parse($item['created_at'])->format('d.m.Y H:i');
            $item['author_data'] = User::find($item['user_id']);
            $item['author_role'] = $this->getRole($item['author_data']['group_id']);
            $item['field'] = $this->getField($item['field_name']);

            if ($item['model_name'] == 'CandidateArrival') {
                $item['model_data'] = Candidate::find($item['parent_model_id']);
            } else {
                $item['model_data'] = Candidate::find($item['model_obj_id']);
            }
            
            if ($item['field_name'] == 'active') {
                $item['prev_value'] = $this->getStatus($item['prev_value']);
                $item['current_value'] = $this->getStatus($item['current_value']);
            } elseif ($item['field_name'] == 'status') {
                $item['prev_value'] = $this->getArrivalStatus($item['prev_value']);
                $item['current_value'] = $this->getArrivalStatus($item['current_value']);
            }

            $result[] = $item;
        }

        return response()->json(array('data' => $result), 200);
    }

    private function getRole($key)
    {
        $dictr = array(
            "1" => "Администратор",
            "2" => "Рекрутер",
            "3" => "Фрилансер",
            "4" => "Логист",
            "5" => "Трудоустройство",
            "6" => "Координатор",
            "7" => "Бухгалтер",
            "8" => "Менеджер поддержки",
        );

        return isset($dictr[$key]) ? $dictr[$key] : $key;
    }

    private function getField($key)
    {
        $dictr = array(
            "firstName" => "Имя",
            "lastName" => "Фамилия",
            "dateOfBirth" => "Дата рождения",
            "phone" => "Телефон",
            "viber" => "Номер Viber",
            "phone_parent" => "Дополнительный контакт",
            "citizenship_id" => "Гражданство",
            "nacionality_id" => "Национальность",
            "country_id" => "Страна прибывания",
            "date_arrive" => "Планируемая дата приезда",
            "type_doc_id" => "Документ",
            "transport_id" => "Транспорт",
            "comment" => "Комментарий",
            "inn" => "ИНН",
            "reason_reject" => "Причина отказа",
            "is_payed" => "",
            "cost_pay" => "",
            "cost_pay_lead" => "",
            "client_id" => "Клиент",
            "logist_date_arrive" => "Дата и время приезда",
            "date_start_work" => "",
            "logist_place_arrive_id" => "Место приезда",
            "real_vacancy_id" => "Вакансия",
            "real_status_work_id" => "Статус трудоустройства",
            "active" => "Статус",
            "status" => "Статус",
        );

        return isset($dictr[$key]) ? $dictr[$key] : $key;
    }

    private function getStatus($key)
    {
        $dictr = array(
            "1" => "Новый кандидат",
            "2" => "Лид",
            "3" => "Отказ",
            "4" => "Готов к выезду",
            "5" => "Архив",
            "6" => "Подтвердил Выезд",
            "7" => "Готов к Работе",
            "8" => "Трудоустроен",
            "9" => "Приступил к Работе",
            "10" => "Отработал 7 дней",
            "11" => "Уволен",
            "12" => "Приехал",
        );

        return isset($dictr[$key]) ? $dictr[$key] : $key;
    }

    private function getArrivalStatus($key)
    {
        $dictr = array(
            "0" => "Готов к выезду",
            "1" => "В пути",
            "2" => "Приехал",
            "3" => "Не доехал",
        );

        return isset($dictr[$key]) ? $dictr[$key] : $key;
    }
}
