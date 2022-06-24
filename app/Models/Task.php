<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function Autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function Candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function getStatus()
    {
        if ($this->status == 1) {
            return 'К выполнению';
        } else if ($this->status == 2) {
            return 'Выполнено';
        };
    }

}
