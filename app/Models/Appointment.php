<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'date',
        'time',
        'type',
        'properties',
        'message',
        'status',
    ];


    public static function booted()
    {
        static::creating(function (Appointment $record) {
            $record->id = Str::ulid();
        });
    }
}
