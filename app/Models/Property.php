<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = array('name', 'prop_group_id', 'priority', 'type');

    public function propertyValues()
    {
        return $this->hasMany('App\Models\PropertyValue', 'property_id', 'id');
    }
}
