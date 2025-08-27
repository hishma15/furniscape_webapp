<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'product_name',
        'no_of_stock',
        'price',
        'type',
        'product_image',
        'description',
        'is_featured',
        'category_id',
        'admin_id'
    ];

    //Relationships

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    //To get the featured products.
    public function scopeFeatured($query) {
        return $query->where('is_featured', true);
    }

}
