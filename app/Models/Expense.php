<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadence_id',
        'payment_date',
        'payment_amount',
        'description'
    ];

    public function cadence()
    {
        return $this->belongsTo(Cadence::class);
    }
}
