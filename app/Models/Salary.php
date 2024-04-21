<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function cadenceDateFormat($cadence)
    {
        $cadence['start'] = Carbon::parse($cadence)->format('Y-m-d');
        return $cadence;
    }

    public function cadence()
    {
        return $this->belongsTo(Cadence::class);
    }
}
