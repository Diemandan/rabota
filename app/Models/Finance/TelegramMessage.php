<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'username',
        'message',
        'update_id',
    ];
}
