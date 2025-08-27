<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'total_amount',
        'order_date',
        'delivery_date',
        'home_no',
        'street',
        'city',
        'status',
        'admin_id',
        'customer_id',
    ];

    //Relationships

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

}
