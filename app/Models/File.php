<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'folder_id',
        'name',
        'links',
    ];

    public static function booted()
    {
        static::creating(function (File $record) {
            $record->id = Str::ulid();
        });
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
