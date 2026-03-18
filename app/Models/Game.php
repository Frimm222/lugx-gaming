<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'games';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'discount_price',
        'original_price',         // если хочешь хранить старую цену отдельно
        'cover_image',
        'game_id_code',           // например: COD MMII, AC VALHALLA и т.д.
        'release_date',
        'developer',
        'publisher',
        'platform',               // PC, PS5, Xbox, Switch...
        'is_featured',
        'is_new',
        'is_on_sale',
        'stock_quantity',         // если есть физические копии или ключи
        'rating_average',
        'rating_count',
        'meta_title',
        'meta_description',
        'views_count',
    ];

    protected $casts = [
        'release_date'    => 'date',
        'is_featured'     => 'boolean',
        'is_new'          => 'boolean',
        'is_on_sale'      => 'boolean',
        'price'           => 'decimal:2',
        'discount_price'  => 'decimal:2',
        'original_price'  => 'decimal:2',
        'rating_average'  => 'decimal:1',
        'views_count'     => 'integer',
        'stock_quantity'  => 'integer',
    ];

    protected $appends = [
        'current_price',
        'discount_percentage',
    ];

    // ----------------- Аксессоры -----------------

    public function getCurrentPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->original_price || $this->original_price <= 0) {
            return 0;
        }

        $discount = $this->original_price - ($this->discount_price ?? $this->price);
        return round(($discount / $this->original_price) * 100);
    }
    /**
     * Пользователь уже оставлял отзыв на эту игру
     */
    public function hasReviewBy(User $user): bool
    {
        return $this->reviews()->where('user_id', $user->id)->exists();
    }

    /**
     * Проверяет, купил ли указанный пользователь эту игру
     * (т.е. есть ли оплаченный заказ с этой игрой)
     */
    public function userHasPurchasedGame(User $user): bool
    {
        return $user->orders()
            ->where('status', 'paid') // или другой статус успешной оплаты
            ->whereHas('items', function ($query) {
                $query->where('game_id', $this->id);
            })
            ->exists();
    }

    /**
     * Возвращает отзыв текущего пользователя на эту игру (если есть)
     */
    public function reviewBy(User $user): ?Review
    {
        return $this->reviews()
            ->where('user_id', $user->id)
            ->first();
    }

    // ----------------- Отношения -----------------

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'game_genre');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'game_tag');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'game_platform');
    }

    /**
     * Отзывы на игру
     */
    public function reviews()
    {
        return $this->hasMany(Review::class)
            ->where('is_published', true)     // только опубликованные
            ->orderByDesc('created_at');
    }

    /**
     * Средний рейтинг (с кэшированием или вычисляемый)
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    /**
     * Количество отзывов
     */
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }


    // ----------------- Scopes -----------------

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('discount_price')
            ->where('discount_price', '<', $this->getTable() . '.price');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNewest($query)
    {
        return $query->orderBy('release_date', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }
}
