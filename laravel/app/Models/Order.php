<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function products(){
        return $this->hasMany(OrderProducts::class, 'order_id', 'id');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("d-m-Y H:i:s", strtotime($value)),
            set: fn ($value) => $value,
        );
    }
}
