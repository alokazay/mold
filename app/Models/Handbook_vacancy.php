<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Handbook_vacancy extends Model
{
    use HasFactory;

    public function Handbooks (){
        return $this->belongsTo(Handbook::class,'handbook_id');
    }
}
