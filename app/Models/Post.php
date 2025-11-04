<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Post extends Model
{
    protected $fillable = [
        "user_id",
        "post_content",
        "is_admin"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
