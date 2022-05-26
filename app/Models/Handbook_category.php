<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handbook_category extends Model
{
    use HasFactory;

    public function Handbooks (){
        return $this->hasMany(Handbook::class,'handbook_category_id')->where('active',1);
    }
}
