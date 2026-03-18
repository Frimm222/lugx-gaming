<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'avatar',
        'birth_date',
        'country',
        'city',
        'phone',
        'is_verified',
        'receives_newsletter',
        'balance',
        'steam_id',
        'epic_id',
        'discord_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'birth_date'            => 'date',
        'balance'               => 'decimal:2',
        'total_spent'           => 'decimal:2',
        'is_verified'           => 'boolean',
        'receives_newsletter'   => 'boolean',
        'last_purchase_at'      => 'datetime',
    ];

    // ------------------ Аксессоры ------------------

    public function getDisplayNameAttribute(): string
    {
        return $this->nickname ?? $this->name ?? 'Игрок #' . $this->id;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // можно fallback на gravatar или дефолтную картинку
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->display_name) . '&size=128';
    }

    // ------------------ Отношения ------------------

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->orderByDesc('created_at');
    }

    public function wishlist()
    {
        return $this->belongsToMany(Game::class, 'wishlist')->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
