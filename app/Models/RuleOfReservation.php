<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class RuleOfReservation extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'rules_of_reservation';

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
    protected $guarded = ['id'];




}
