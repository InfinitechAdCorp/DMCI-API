<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',    
    ];

    public static function booted()
    {
        static::creating(function (User $record) {
            $record->id = Str::ulid();
        });
    }   

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listings::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

   
}
