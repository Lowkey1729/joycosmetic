<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    protected $fillable = array('order_id', 'product_id', 'is_related_product', 'price', 'qty');
    protected $table = 'order_data';

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id','id');
    }
}
