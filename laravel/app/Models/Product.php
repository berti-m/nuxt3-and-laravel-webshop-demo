<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ordered(){
        return $this->hasMany(OrderProducts::class, 'product_id', 'id');
    }
}
