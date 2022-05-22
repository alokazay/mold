<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client_contact extends Model
{
    use HasFactory;

    //  UUID
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            $course->{$course->getKeyName()} = (string) Str::uuid();
        });
    }
    public function getIncrementing()
    {
        return false;
    }
    public function getKeyType()
    {
        return 'string';
    }
    //  UUID
}

