<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderData;

class AdminOrdersController extends Controller
{
    private $user;
    private $order;
    private $orderData;

    public function __construct (User $user, Order $order, OrderData $orderData)
    {
        $this->middleware('admin');
        $this->user = $user;
        $this->order = $order;
        $this->orderData = $orderData;
    }

    public function list()
    {
        $orders = $this->order->orderBy('created_at', 'desc')->get();
        $counts = Order::count();
        return view('admin.orders', ['orders' => $orders, 'counts'=>$counts]);
    }

    public function showEditForm (int $id)
    {
        $orders = $this->orderData->where('order_id',$id)->get();
        $counts = OrderData::where('order_id',$id)->count();

        return view('admin.order_data', ['orders'=>$orders, 'counts'=>$counts]);
    }
}
