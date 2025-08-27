<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_desc',
        'category_image',
        'admin_id',
    ];

    //Relationships

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

}
