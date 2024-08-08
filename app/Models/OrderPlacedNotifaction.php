<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPlacedNotifaction extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'order_id', 'seen'];
}
