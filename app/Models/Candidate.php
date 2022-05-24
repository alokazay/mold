<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public function Vacancy (){
        return $this->belongsTo(Vacancy::class,'real_vacancy_id');
    }

    public function D_file(){
        return $this->hasOne(C_file::class)->where('type', 3);
    }
}
