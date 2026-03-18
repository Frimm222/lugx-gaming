<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_platform');
    }
}
