<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PropertyListings extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'property_id',
        'property_location',
        'property_price',
        'property_building',
        'property_type',
        'property_size',
        'property_parking',
        'property_description',
        'property_level',
        'property_amenities',
        'property_featured',
        'images',
    ];

    public static function booted()
    {
        static::creating(function (PropertyListings $record) {
            $record->id = Str::ulid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class); 
    }
}


