<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'status',
        'amount',
        'payment_date',
        'order_id',
    ];

    //Realtionships
    
    public function order() {
        return $this->belongsTo(Order::class);
    }

}
