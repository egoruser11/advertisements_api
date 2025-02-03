<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class Reservation extends Authenticatable
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_WAITPAYED = 'wait_payed';

    public const STATUS_CANCEL = 'cancel';



    use HasApiTokens, HasFactory, Notifiable;


    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


}
