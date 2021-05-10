<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeShippingMethod extends ShippingMethod
{
    static function getRate()
    {
        return 0;
    }

    static function getLabel()
    {
        return 'Free Shipping';
    }

    static function getDeliveryTime ()
    {
        return '1-2 weeks';
    }
}
