<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    protected $table = 'user_settings';

    protected $fillable = [
        'telegram_api_key',
        'telegram_chat_id',
        'tradernet_user_id',
        'tradernet_api_key',
        'sid',
        'notify_frequency'
    ];
}
