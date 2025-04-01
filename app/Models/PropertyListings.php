<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PropertyListings extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'property_name',
        'property_location',
        'property_price',
        'property_type',
        'property_size',
        'property_bldg',
        'property_level',
        'property_amenities',
        'property_parking',
        'property_featured',
        'property_images',
        'property_description'
    ];

    public static function booted()
    {
        static::creating(function (Property $record) {
            $record->id = Str::ulid();
        });
    }
}


