<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'city',
        'country',
        'line1',
        'line2',
        'postal_code',
        'phone',
    ];
}
