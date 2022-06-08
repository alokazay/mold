<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Candidate_arrival extends Model
{
    use HasFactory;

    public function Place_arrive()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 8);
    }

    public function Transport()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 7);
    }
    public function Candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function getStatusOptions()
    {
        $arr = [
            ['1', 'Новый кандидат'],
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

        if (Auth::user()->isLogist()) {
            $arr = [
                ['3', 'Отказ'],
                ['4', 'Готов к выезду'],
                ['6', 'Подтвердил Выезд'],
            ];
        }

        $html = '';
        foreach ($arr as $a) {
            if ($a[0] == $this->status) {
                $html .= '<option selected value="' . $a[0] . '">' . $a[1] . '</option>';
            } else {
                $html .= '<option value="' . $a[0] . '">' . $a[1] . '</option>';
            }
        }
        return $html;
    }
}
