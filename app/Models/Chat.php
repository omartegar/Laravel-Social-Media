<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        "sender_id",
        "receiver_id",
        "message_content",
        "is_important"
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // العلاقة مع المستخدم المستقبل
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
