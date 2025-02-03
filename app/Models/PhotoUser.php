<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class PhotoUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user_photo';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
