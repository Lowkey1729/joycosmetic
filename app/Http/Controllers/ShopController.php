<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as V;
use App\Models\Catalog;
use App\Models\Property;
use App\Models\Order;
use App\Models\OrderData;

class ShopController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $catalog;
    private $order;
    private $orderData;

    public function __construct (Catalog $catalog, Order $order, OrderData $orderData)
    {
        $this->catalog = $catalog;
        $this->order = $order;
        $this->orderData = $orderData;
    }

    public function list ()
    {
        $products = Product::with('catalogs')->with('properties')->paginate(12);
        $categories = Catalog::all();
        /**
         * @var \Illuminate\View\View $view
         */
        // $view = View::make('shop', ['products' => $products]);
        // $view->nest('links', 'layouts.links');
        return   view('client.home',['products'=>$products, 'categories'=>$categories]);
    }

    public function get_product ($id)
    {
        $product = Product::with('catalogs')->find($id);
        $categories = Catalog::all();
        return View('client.each_product', ['product' => $product, 'categories'=>$categories]);
    }

    public function get_child_catalogs ($id)
    {
        $child_catalogs = Catalog::where('id', $id)->first();
        $products =Catalog::find($id)->products()->paginate(6);
        $categories = Catalog::all();
       return  View('client.category', ['products' => $products,'categories'=>$categories, 'catalogs' => $child_catalogs]);

    }

   public function orders($id)
   {
        $orders = $this->order->where('user_id',$id)->get();
        $categories = Catalog::all();
        return view('client.order',['orders' => $orders,'categories'=>$categories]);
   }

   public function order_data($id)
   {
    $orders = $this->orderData->where('order_id',$id)->get();

        $categories = Catalog::all();
        return view('client.order-data',['orders' => $orders,'categories'=>$categories]);
   }
}
