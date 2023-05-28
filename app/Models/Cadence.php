<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadence extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_rate',
        'status_finish',
        'start',
        'finish',
    ];

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function debt()
    {
        return $this->hasOne(Debt::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

}
