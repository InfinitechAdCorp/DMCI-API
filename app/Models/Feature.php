<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'property_id',
        'name',
    ];

    public static function booted()
    {
        static::creating(function (Feature $record) {
            $record->id = Str::ulid();
        });
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
