<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Catalog;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Order;
use Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct ()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::count();
        $products = Product::count();
        $categories = Catalog::count();
        $orders = Order::count();
        $payments = Payment::count();
        $new_orders = Order::whereDate('created_at',   Carbon::now()->toDateString())->count();
        $new_users = User::where('created_at', '>=',  Carbon::now()->subDays(7)->startofDay())->count();
        return view('admin.dashboard', ['users'=>$users, 'new_users'=>$new_users, 'products'=>
        $products,'categories'=>$categories, 'orders'=>$orders, 'payments'=>$payments, 'new_orders'=>$new_orders
        ]);
    }

    public function payment()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get();
        $counts = Payment::count();
        return view('admin.payments', ['payments'=>$payments, 'counts'=>$counts]);
    }
}
