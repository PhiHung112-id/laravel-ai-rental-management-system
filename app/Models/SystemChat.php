<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemChat extends Model
{
    protected $table = 'system_chat';

    protected $fillable = [
        'user_id',
        'user_type',
        'message',
        'created_at',
        'updated_at',
        'is_edited'
    ];

    public $timestamps = true;
}