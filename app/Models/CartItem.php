<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;
    //

    protected $fillable = [
        'price',
        'quantity',
        'cart_id',
        'product_id',
    ];

    //Relationships

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute() {
        return $this->price * $this->quantity;
    }

}
