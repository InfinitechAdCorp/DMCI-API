<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Listings extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
      'id',
      'user_id',
      'name',
      'email',
      'phone',
      'unit_name',
      'unit_type',
      'unit_location',
      'unit_price',
      'status',
      'images',
     
    ];

    public static function booted(){
        static::creating(function (Listings $record){
            $record->id = Str::ulid();
        });
    }



}
