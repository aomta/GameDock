<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'image',
        'genre',
        'developer',
        'publisher',
        'release_date',
        'active',
        'os_minimum',
        'processor_minimum',
        'memory_minimum',
        'graphics_minimum',
        'storage_minimum',
        'os_recommended',
        'processor_recommended',
        'memory_recommended',
        'graphics_recommended',
        'storage_recommended',
    ];

    protected $casts = [
        'release_date' => 'date',
        'purchased_at' => 'datetime',
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->title);
            }
        });
        static::updating(function ($game) {
            if ($game->isDirty('title') && empty($game->slug)) {
                $game->slug = Str::slug($game->title);
            }
        });
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
