<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public function Vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'real_vacancy_id');
    }

    public function D_file()
    {
        return $this->hasOne(C_file::class)->where('type', 3);
    }

    public function Citizenship()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 10);
    }

    public function Country()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 5);
    }

    public function Type_doc()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 6);
    }

    public function Logist_place_arrive()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 8);
    }

    public function Real_status_work()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 9);
    }

    public function Transport()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 7);
    }

    public function getStatusOptions()
    {
        $arr = [
            ['', 'Новый кандидат'],
            ['2', 'Лид'],
            ['3', 'Отказ'],
            ['4', 'Готов к выезду'],
            ['5', 'Архив'],
            ['6', 'Подтвердил Выезд'],
            ['7', 'Готов к Работе'],
            ['8', 'Трудоустроен'],
            ['9', 'Приступил к Работе'],
            ['10', 'Отработал 7 дней'],
            ['11', 'Уволен'],
            ['12', 'Приехал'],
        ];

        $html = '';
        foreach ($arr as $a) {
            if ($a[0] == $this->active) {
                $html .= '<option selected value="' . $a[0] . '">' . $a[1] . '</option>';
            } else {
                $html .= '<option value="' . $a[0] . '">' . $a[1] . '</option>';
            }
        }
        return $html;
    }


}
