<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Advertisement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assessements()
    {
        return $this->hasMany(Assessment::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function photos()
    {
        return $this->hasMany(FileAdvertisement::class);
    }

    public function condition()
    {
        return $this->hasOne(Condition::class);
    }

    public function params()
    {
        return $this->belongsToMany(Param::class)->withPivot('value');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

}
