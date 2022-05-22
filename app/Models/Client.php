<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function h_v_industry()
    {
        return $this->hasMany(Handbook_client::class)->where('handbook_category_id', 1);
    }

    public function h_v_city()
    {
        return $this->hasMany(Handbook_client::class)->where('handbook_category_id', 3);
    }

    public function Coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function Contacts()
    {
        return $this->hasMany(Client_contact::class);
    }

}
