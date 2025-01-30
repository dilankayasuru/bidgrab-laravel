<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use Carbon\Carbon;

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
        'starting_price',
        'current_price',
        'bids'
    ];

    protected $casts = [
        'starting_price' => 'float',
        'current_price' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($auction) {
            $auction->end_date = Carbon::parse($auction->start_date)
                ->addDays((int)$auction->duration);
            $auction->status = "pending";
            $auction->winner_id = null;
        });
    }
}
