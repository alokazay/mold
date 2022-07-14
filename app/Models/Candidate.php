<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function D_file_karta()
    {
        return $this->hasOne(C_file::class)->where('type', 103);
    }
    public function D_file_driver()
    {
        return $this->hasOne(C_file::class)->where('type', 104);
    }
    public function D_file_diplom()
    {
        return $this->hasOne(C_file::class)->where('type', 105);
    }
    public function D_file_legitim()
    {
        return $this->hasOne(C_file::class)->where('type', 106);
    }
    public function D_file_else()
    {
        return $this->hasOne(C_file::class)->where('type', 107);
    }

    public function getPasportLink()
    {
        if ($this->D_file != null) {
            if (config('app.env') === 'local') {
                $path_url = url('/');
            } else {
                $path_url = url('/') . '/public';
            }
            return $path_url . $this->D_file->path;
        } else {
            return '';
        }
    }

    public function getKartapobytu()
    {
        if ($this->D_file_karta != null) {
            if (config('app.env') === 'local') {
                $path_url = url('/');
            } else {
                $path_url = url('/') . '/public';
            }
            return $path_url . $this->D_file_karta->path;
        } else {
            return '';
        }
    }

    public function getDriverLicense()
    {
        if ($this->D_file_driver != null) {
            if (config('app.env') === 'local') {
                $path_url = url('/');
            } else {
                $path_url = url('/') . '/public';
            }
            return $path_url . $this->D_file_driver->path;
        } else {
            return '';
        }
    }

    public function getDiplom()
    {
        if ($this->D_file_diplom != null) {
            if (config('app.env') === 'local') {
                $path_url = url('/');
            } else {
                $path_url = url('/') . '/public';
            }
            return $path_url . $this->D_file_diplom->path;
        } else {
            return '';
        }
    }

    public function getLegitim()
    {
        if ($this->D_file_legitim != null) {
            if (config('app.env') === 'local') {
                $path_url = url('/');
            } else {
                $path_url = url('/') . '/public';
            }
            return $path_url . $this->D_file_legitim->path;
        } else {
            return '';
        }
    }

    public function getElsefile()
    {
        if ($this->D_file_else != null) {
            if (config('app.env') === 'local') {
                $path_url = url('/');
            } else {
                $path_url = url('/') . '/public';
            }
            return $path_url . $this->D_file_else->path;
        } else {
            return '';
        }
    }

    public function Citizenship()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 10);
    }

    public function Nacionality()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 2);
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

    public function Candidate_arrival()
    {
        return $this->hasMany(Candidate_arrival::class);
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Transport()
    {
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 7);
    }

    public function getStatus(){
        $status = '';
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
            ['13', 'Архив (отказ)'],
            ['14', 'Перезвонить'],
            ['15', 'Недозвон'],
            ['16', 'Оформление'],
        ];
        $status = $this->active;
        foreach ($arr as $a){
            if($this->active == $a[0] ){
                $status  = $a[1];
            }
        }
        return $status;
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
            ['13', 'Архив (отказ)'],
            ['14', 'Перезвонить'],
            ['15', 'Недозвон'],
            ['16', 'Оформление'],
        ];

        if (Auth::user()->isRecruter()) {
            $arr = [
                ['1', 'Новый кандидат'],
                ['2', 'Лид'],
                ['3', 'Отказ'],
                ['4', 'Готов к выезду'],
                ['5', 'Архив'],
                ['13', 'Архив (отказ)'],
                ['14', 'Перезвонить'],
                ['15', 'Недозвон'],
                ['16', 'Оформление'],
            ];
        }

        if (Auth::user()->isFreelancer()) {
            $arr = [
                ['1', 'Новый кандидат'],
                ['2', 'Лид'],
                ['3', 'Отказ'],
                ['4', 'Готов к выезду'],
                ['5', 'Архив'],
                ['10', 'Отработал 7 дней']
            ];
        }

        if (Auth::user()->isLogist()) {
            $arr = [
                ['3', 'Отказ'],
                ['4', 'Готов к выезду'],
                ['6', 'Подтвердил Выезд'],
            ];
        }

        if (Auth::user()->isKoordinator()) {
            $arr = [
                ['3', 'Отказ'],
                ['7', 'Готов к Работе'],
                ['8', 'Трудоустроен'],
                ['9', 'Приступил к Работе'],
                ['10', 'Отработал 7 дней'],
                ['11', 'Уволен']
            ];
        }
        if (Auth::user()->isTrud()) {
            $arr = [
                ['3', 'Отказ'],
                ['6', 'Подтвердил Выезд'],
                ['8', 'Трудоустроен']
            ];
        }

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
