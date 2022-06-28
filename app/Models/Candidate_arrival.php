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

    public function D_file()
    {
        return $this->belongsTo(C_file::class, 'file_id')->where('type', 6);
    }

    public function getStatusOptions()
    {
        $arr = [
            ['0', 'Ожидание'],
            ['1', 'В пути'],
            ['2', 'Приехал'],
            ['3', 'Не доехал']
        ];

        if (Auth::user()->isLogist()) {
            $arr = [
                ['0', 'Нет статуса'],
                ['1', 'В пути']
            ];
        }

        if (Auth::user()->isTrud()) {
            $arr = [
                ['1', 'В пути'],
                ['2', 'Приехал'],
                ['3', 'Не доехал']
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
