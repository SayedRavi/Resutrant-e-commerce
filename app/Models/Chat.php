<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'receiver_id', 'sender_id'];

    function sender(){
        return $this->belongsTo(User::class, 'sender_id')->select('id', 'avatar');
    }

    function receiver(){
        return $this->belongsTo(User::class, 'receiver_id')->select('id', 'avatar');
    }
}
