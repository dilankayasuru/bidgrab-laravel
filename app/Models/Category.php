<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function auction(): HasMany
    {
        return $this->hasMany(Auction::class);
    }
}
