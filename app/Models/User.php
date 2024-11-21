<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasFactory;
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',    
    ];

    public static function booted()
    {
        static::creating(function (User $record) {
            $record->user_id = Str::ulid();
        });
    }

    public function property(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function listing(): HasMany
    {
        return $this->hasMany(Listings::class);
    }

    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

   
}
