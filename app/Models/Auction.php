<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use Carbon\Carbon;
use MongoDB\Laravel\Relations\HasOne;

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
        'bid_count',
        'specs',
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

    public function highestBid(): BelongsTo
    {
        return $this->belongsTo(Bid::class, 'highest_bid');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($auction) {
            $auction->end_date = Carbon::parse($auction->start_date)
                ->addDays((int)$auction->duration);
            $auction->status = "pending";
        });
    }
}
