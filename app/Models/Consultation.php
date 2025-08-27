<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'prefered_date',
        'prefered_time',
        'status',
        'mode',
        'topic',
        'description',
        'admin_id',
        'customer_id',
    ];

    // Relationships
    
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

}
