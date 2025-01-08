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

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
