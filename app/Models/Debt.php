<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'cadence_id',
        'debt'
    ];

    public function cadence()
    {
        return $this->belongsTo(Cadence::class);
    }
}
