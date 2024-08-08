<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoinal extends Model
{
    use HasFactory;
    protected $fillable = ['image','name','title','review','rating','show_at_home','status'];
}
