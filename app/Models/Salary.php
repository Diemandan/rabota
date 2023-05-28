<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadence_id',
        'transfer_date',
        'transfer_amount'
    ];


    public function cadence()
    {
        return $this->belongsTo(Cadence::class);
    }
}
