<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'is_verified',
        'is_published',
    ];

    protected $casts = [
        'rating'        => 'integer',
        'is_verified'   => 'boolean',
        'is_published'  => 'boolean',
        'created_at'    => 'datetime',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    // Пример аксессора: короткий текст для превью
    public function getExcerptAttribute(): string
    {
        return \Str::limit($this->comment ?? '', 120);
    }
}
