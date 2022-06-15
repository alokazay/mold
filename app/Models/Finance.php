<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Finance extends Model
{
    use HasFactory;

    public function getStatus()
    {
        if ($this->status == 1) {
            return 'В ожидании';
        } else if ($this->status == 2) {
            return 'Оплачен';
        }
    }

    public function getStatusOptions()
    {
        $arr = [
            ['1', 'В ожидании'],
            ['2', 'Оплачен'],
        ];

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

    public function D_file()
    {
        return $this->belongsTo(C_file::class, 'file_id')->where('type', 5);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
