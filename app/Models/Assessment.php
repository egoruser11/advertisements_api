<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Assessment extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'assessments';

    public const STATUS_WAITING = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function getIsBlockedAttribute(): bool
    {
        return $this->status == self::STATUS_BLOCKED;
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    protected $guarded = ['id'];


}
