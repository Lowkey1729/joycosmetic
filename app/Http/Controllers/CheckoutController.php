<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\RelatedProduct;

class CheckoutController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $product;
    private $relatedProduct;


    public function __construct(Product $product,
                                RelatedProduct $relatedProduct)
    {
        $this->product = $product;
        $this->relatedProduct = $relatedProduct;

        $this->middleware('auth')->except('logout');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPayment(Request $request)
    {

        $result = $request->all();
        $response = $request->all();

        // submit pay
        $length = count(json_decode($result['productId'], true));


        $order_label = env('APP_ORDERS_PREFIX', 'jyc').'_'.time();

        $subtotal = $request->get('subtotal');

        $orderId = Order::insertGetId(
            [
                'commentary' => '',
                'total' => $subtotal,
                'status' => 'completed',
                'order_label' => $order_label,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

        for ($i = 0; $i < $length; $i++) {

            $result =  json_decode($response['productId'], true);
            $price = $this->product->find($result[$i]['id'])->price;

                OrderData::insert(
                [
                    'order_id' => $orderId,
                    'product_id' => $result[$i]['id'],
                    'is_related_product' =>1,
                    'price' => $price,
                    'qty' => $result[$i]['qty'],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );


        }



        if (session()->has('cartProducts')) {
            session()->forget('cartProducts');
        }
        Auth::user()->cart = '';
        Auth::user()->save();

        return "done";


    }

    public function onDelivery(Request $request)
    {

        $result = $request->all();
        $response = $request->all();

        // submit pay
        $length = count(json_decode($result['productId'], true));


        $order_label = env('APP_ORDERS_PREFIX', 'jyc').'_'.time();

        $subtotal = $request->get('subtotal');

        $orderId = Order::insertGetId(
            [
                'commentary' => '',
                'total' => $subtotal,
                'status' => 'Payment on Delivery',
                'order_label' => $order_label,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

        for ($i = 0; $i < $length; $i++) {

            $result =  json_decode($response['productId'], true);
            $price = $this->product->find($result[$i]['id'])->price;

                OrderData::insert(
                [
                    'order_id' => $orderId,
                    'product_id' => $result[$i]['id'],
                    'is_related_product' =>1,
                    'price' => $price,
                    'qty' => $result[$i]['qty'],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );


        }



        if (session()->has('cartProducts')) {
            session()->forget('cartProducts');
        }
        Auth::user()->cart = '';
        Auth::user()->save();

        return "done";


    }

    public function success (Request $request)
    {
        if (!empty($request->get('response_status')) && ($request->get('response_status') === 'success')) {
            Order::where('order_label', $request->get('order_id'))->update(['status' => 'process']);
            return redirect('checkout/success')->with('message', "Thank's. Your payment has been successfully completed! The Order #".$request->get('order_id')." has been created.");
        }
        return redirect('checkout/success')->with('error', 'Payment is NOT successful. PLS, try again');

    }


}
