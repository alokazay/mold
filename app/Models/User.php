<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGroup()
    {
        if ($this->group_id == 1) {
            return 'Администратор';
        } else if ($this->group_id == 2) {
            return 'Рекрутер';
        } else if ($this->group_id == 3) {
            return 'Фрилансер';
        } else if ($this->group_id == 4) {
            return 'Логист';
        } else if ($this->group_id == 5) {
            return 'Трудоустройство';
        } else if ($this->group_id == 6) {
            return 'Координатор';
        } else if ($this->group_id == 7) {
            return 'Бухгалтер';
        } else if ($this->group_id == 8) {
            return 'Менеджер поддержки';
        }
    }

    public function isAdmin()
    {
        if (Auth::user()->group_id == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function isRecruter()
    {
        if (Auth::user()->group_id == 2) {
            return true;
        } else {
            return false;
        }
    }
    public function isFreelancer()
    {
        if (Auth::user()->group_id == 3) {
            return true;
        } else {
            return false;
        }
    }
    public function isLogist()
    {
        if (Auth::user()->group_id == 4) {
            return true;
        } else {
            return false;
        }
    }
    public function isTrud()
    {
        if (Auth::user()->group_id == 5) {
            return true;
        } else {
            return false;
        }
    }
    public function isKoordinator()
    {
        if (Auth::user()->group_id == 6) {
            return true;
        } else {
            return false;
        }
    }
    public function isAccountant()
    {
        if (Auth::user()->group_id == 7) {
            return true;
        } else {
            return false;
        }
    }
    public function isSupportManager()
    {
        if (Auth::user()->group_id == 8) {
            return true;
        } else {
            return false;
        }
    }

    public function getActivation()
    {
        if ($this->activation == 1) {
            return 'Активирован';
        } else if ($this->activation == 2) {
            return 'Деактивирован';
        }
    }

    public function getFl_status()
    {
        if ($this->fl_status == 1) {
            return 'Новый';
        } else if ($this->fl_status == 2) {
            return 'Верифицирован';
        } else if ($this->fl_status == 2) {
            return 'Отклонён';
        } else if ($this->fl_status == 2) {
            return 'Уволен';
        }
    }
    public function getPaymentFl()
    {
        if ($this->account_type == 1) {
            return 'Польский';
        } else if ($this->account_type == 2) {
            return 'Заграничный';
        } else if ($this->account_type == 3) {
            return 'PayPal';
        }
    }


    public function D_file()
    {
        return $this->hasOne(C_file::class)->where('type', 1);
    }

    public function Recruter()
    {
        return $this->belongsTo(User::class, 'recruter_id');
    }
    public function Manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function Candidates()
    {
        return $this->hasMany(Candidate::class, 'user_id');
    }

}






