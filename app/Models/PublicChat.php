<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicChat extends Model
{
    protected $fillable = [
        "sender_id",
        "message_text",
        "is_important"
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
