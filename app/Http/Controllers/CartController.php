<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catalog;
use App\Library\Services\CartService;


class CartController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $product;
    private $shippingMethod;
    private $relatedProduct;
    private $cartService;
    private $request;

    public function __construct (Product $product,CartService $cartService, Request $request)
    {
        $this->product = $product;
        $this->cartService = $cartService;
        $this->request = $request;

        // $this->middleware('auth')->except('logout');
    }

    public function index ()
    {        
        $cartProducts = session('cartProducts');
        $categories = Catalog::all();
        $product_carts = [];
        $products = [];
        $index = 0;
        if(empty($cartProducts))
        {

            return view('client.cart', ['categories'=> $categories, 'product_carts' => $product_carts]);
        }
       
    

        foreach ($cartProducts as $key => $cartProduct) {

            if ($key === 'total') {
                continue;
            }
           
            $products[$index] = $this->product->find($key);
            $products[$index]->qty = $cartProduct['productQty'];
            $product_carts[] = $products[$index];
            $index++;
        }
        // return $product_carts;
        $this->request->session()->put('quantity', count($product_carts));
        return view('client.cart', ['product_carts' => $product_carts, 'categories'=>$categories]);
    }

    public function post (Request $request)
    {
        if (isset($request->input))
        {

            if($request->input == 'emptyCart')
            {
                $categories = Catalog::all();
            return view('client.cart', ['categories', $categories]);

            }
            elseif($request->get('input') == 'removeRow')
            { //Product has been removed (ajax)

                $productId = $request->get('productId');
                if ($request->session()->has('cartProducts'))
                {

                    $cartProducts = $request->session()->get('cartProducts');

                    if (array_key_exists($productId, $cartProducts))
                    {


                        unset($cartProducts[$productId]);

                        if (count($cartProducts) <= 1) {
                            $request->session()->forget('cartProducts');
                            return ['items' => 0, 'total' => 0];
                        }

                        $cartProducts['total'] = $request->get('subtotal');
                        $request->session()->forget('cartProducts');
                        $request->session()->put('cartProducts', $cartProducts);
                    }
                    return ['items' => (count($cartProducts) - 2), 'total' => $cartProducts['total']];
                }
                return 0;
            }

        }
    }


    public function updateCart(Request $request)
    {
        $productId = $request->get('productId');
        $qty = $request->get('productQty');
        $this->cartService->updateQty($productId, $qty);


        return redirect('cart/client/cart');

    }

    public function addToCart (Request $request)
    {
        $request->validate(
            [
                'productId' => 'required|integer|min:1|max:99999',
                'productQty' => 'required|integer|min:1|max:99'
            ],
            [
                'productQty.required' => 'The Quantity field can not be blank.',
                'productQty.integer' => 'Quantity must be integer.',
                'productQty.min' => 'Minimum of Quantity is 1 psc.',
                'productQty.max' => 'Maximum of Quantity is 99 psc.'
            ]);

        $productId = $request->get('productId');
        $qty = $request->get('productQty');

        if ($request->get('updateQty')) {
            $this->cartService->updateQty($productId, $qty);
        } else {
            $this->cartService->addToCart($productId, $qty);
        }



        return redirect('cart/client/cart');
    }
}
