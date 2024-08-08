<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryArea()
    {
        return $this->belongsTo(DeliveryArea::class);
    }

    public function userAddress(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    return $this->belongsTo(Adress::class, 'address_id' ,'id');
    }


    function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
