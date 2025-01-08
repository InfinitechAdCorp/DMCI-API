<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AgentProfile extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 
        'image',
        'first_name', 
        'last_name', 
        'position', 
        'email', 
        'phone_number', 
        'facebook', 
        'instagram', 
        'telegram', 
        'viber', 
        'whatsapp', 
        'about_me'
    ]   ;

    public static function booted()
    {
        static::creating(function (AgentProfile $record) {
            $record->id = Str::ulid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
}