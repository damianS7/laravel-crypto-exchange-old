<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    public $timestamps = false;
    protected $table = "chat_messages";
}
