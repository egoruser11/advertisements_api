<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public const SECRET_CODE_LENGTH = 25;
    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';
    public const SECRET_CODE_RESEND_PERIOD_MAX = 90; //минуты
    public const SECRET_CODE_RESEND_PERIOD_MIN = 2; //минуты

    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_SELLER = 'seller';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = ['id'];

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
        'secret_code_at' => 'datetime',
        'phone_code_at' => 'datetime',
    ];

    public function setSecretCode(): void
    {
        $this->secret_code = Str::lower(Str::random(User::SECRET_CODE_LENGTH));
        $this->secret_code_at = now();
        $this->save();
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    public function favoriteAdvertisements(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'favorite_advertisements');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoUser::class);
    }
}
