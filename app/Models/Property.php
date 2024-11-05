<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'logo',
        'slogan',
        'description',
        'location',
        'min_price',
        'max_price',
        'status',
        'percent',
        'media',
    ];
}
