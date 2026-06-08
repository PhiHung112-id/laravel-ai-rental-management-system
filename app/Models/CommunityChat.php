<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityChat extends Model
{
    protected $table = 'community_chats';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_type',
        'message',
        'date_created',
    ];
}