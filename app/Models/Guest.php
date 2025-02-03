<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class Guest extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    protected $guarded = ['id'];




}
