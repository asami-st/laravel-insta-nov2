<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // who send message
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'send_user_id');
    }

    // who reseive message
    public function toUser()
    {
        return $this->belongsTo(User::class, 'recieve_user_id');
    }
}
