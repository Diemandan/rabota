<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table = 'portfolio';

    protected $fillable = [
        'symbol',
        'type',
        'quantity',
        'purchase_price',
        'stop_loss',
        'take_profit',
        'added_at'
    ];

    protected $casts = [
        'quantity' => 'float',
        'purchase_price' => 'float',
        'stop_loss' => 'float',
        'take_profit' => 'float',
        'added_at' => 'datetime'
    ];
}
