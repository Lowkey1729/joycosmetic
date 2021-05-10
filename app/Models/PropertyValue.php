<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    protected $fillable = array('property_id', 'value', 'unit_id');

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_property', 'property_value_id','product_id' )->withTimestamps();
    }

    public function properties()
    {
        return $this->belongsTo('App\Models\Property', 'property_id','id');
    }
}
