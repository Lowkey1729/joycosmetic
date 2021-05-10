<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;
    protected $fillable = array('commentary', 'total', 'status', 'order_label');

    public function orderData ()
    {
        return $this->hasMany('App\Models\OrderData', 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getOrderByLabel(string $label)
    {
        return $this->where('order_label', 'like' ,  '%'.$label.'%');
    }

    public function getOrdersByUserId(int $id)
    {
        return $this->where('user_id', $id);
    }

    public function getOrderById(int $id)
    {
        return $this->find($id);
    }
}
