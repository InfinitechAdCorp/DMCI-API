<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Career extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'referrer',
        'sub_agent',
        'broker',
        'partner',
        'position',
        'image',
    ];

    public static function booted() {
        static::creating(function (Career $record) {
            $record->id = Str::ulid();
        });
    }
}
