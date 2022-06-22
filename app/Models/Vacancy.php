<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    public function h_v_industry (){
        return $this->hasMany(Handbook_vacancy::class)->where('handbook_category_id', 1);
    }
    public function h_v_city (){
        return $this->hasMany(Handbook_vacancy::class)->where('handbook_category_id', 3);
    }
    public function h_v_nacionality (){
        return $this->hasMany(Handbook_vacancy::class)->where('handbook_category_id', 2);
    }

    public function Vacancy_client (){
        return $this->hasMany(Vacancy_client::class);
    }
    public function Doc (){
        return $this->belongsTo(Handbook::class)->where('handbook_category_id', 4);
    }


}
