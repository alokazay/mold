<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FieldsMutation;
use Carbon\Carbon;
use App\Models\User;

class FieldsMutationController extends Controller
{
    public function getIndex()
    {
        $data = FieldsMutation::all();

        $roles = array();

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

        foreach ($data as $item) {
            $user = User::find($item['user_id']);
            $roles[$user->group_id] = $roles_ids[$user->group_id];
        }

        return view('fields-mutation.index', compact('roles_ids'));
    }

    public function getJson(Request $request)
    {
        $data = null;

        if ($request->roles) {
            $data = FieldsMutation::where('user_role', $request->roles)->orderBy('created_at', 'DESC')->get();
        } else {
            $data = FieldsMutation::orderBy('created_at', 'DESC')->get();
        }

        $result = array();

        foreach ($data as $item) {
            $item['date_time'] = Carbon::parse($item['created_at'])->format('d.m.Y H:i');
            $item['author_data'] = User::find($item['user_id']);
            $item['author_role'] = $this->getRole($item['author_data']['group_id']);
            $item['field'] = $this->getField($item['field_name']);

            $result[] = $item;
        }

        return response()->json(array('data' => $result), 200);
    }

    private function getRole($key)
    {
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

        return $roles_ids[$key];
    }

    private function getField($key)
    {
        $roles_ids = array(
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
            "reason_reject" => "",
            "is_payed" => "",
            "cost_pay" => "",
            "cost_pay_lead" => "",
            "client_id" => "Клиент",
            "logist_date_arrive" => "Дата и время приезда",
            "date_start_work" => "",
            "logist_place_arrive_id" => "Место приезда",
            "real_vacancy_id" => "Вакансия",
            "real_status_work_id" => "Статус трудоустройства",
            "active" => "",
        );

        return $roles_ids[$key];
    }
}
