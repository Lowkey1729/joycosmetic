<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixRateShippingMethod extends ShippingMethod
{

    static function getRate()
    {
        return 15;
    }

    static function getLabel()
    {
        return 'Fix Rate Shipping';
    }

    static function getDeliveryTime ()
    {
        return '5-7 days';
    }
}
