<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'career_id',
        'name',
        'email',
        'phone',
        'address',
        'resume'
    ];

    public static function booted()
    {
        static::creating(function (Application $record) {
            $record->id = Str::ulid();
        });
    }

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }
}
