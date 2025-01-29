<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Auction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'images',
        'category_id',
        'condition',
        'duration',
        'starting_date',
        'starting_price'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
