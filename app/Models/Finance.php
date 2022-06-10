<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function D_file()
    {
        return $this->belongsTo(C_file::class,'file_id')->where('type', 5);
    }

}
