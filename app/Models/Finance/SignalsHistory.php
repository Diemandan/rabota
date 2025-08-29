<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class SignalsHistory extends Model
{
    protected $table = 'signals_history';

    protected $fillable = [
        'symbol',
        'signal_type',
        'rsi',
        'price',
        'sent_at'
    ];

    protected $casts = [
        'rsi' => 'float',
        'price' => 'float',
        'sent_at' => 'datetime'
    ];
}
