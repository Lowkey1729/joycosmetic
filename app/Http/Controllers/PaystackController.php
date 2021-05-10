<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Auth;

class PaystackController extends Controller
{

    public function __construct(Request $request, Payment $payment)
	{
	    $this->middleware('web');
		$this->request = $request;
		$this->payment = $payment;
	}


    public function success(Request $request)
    {
        $payment = $this->payment;
        $payment->amount = $request->amount;
        $payment->user_id =  Auth::user()->id;
        $payment->payment_mode = "Paystack";
        $payment->payment_id = $request->reference;
        // if($payment->payment_id != rand(11111111,99999999))
        // {
        //     $payment->payment_id = rand(11111111,99999999);
        // }
        // else
        // {
        //     $payment->payment_id = rand(11111111,99999999);
        // }
        $payment->save();
    }
}
