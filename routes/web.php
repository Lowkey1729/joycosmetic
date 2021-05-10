<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Catalog;
use App\Models\Product;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\AdminCategoriesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrdersController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminShippingMethodsController;
use App\Http\Controllers\AdminPropertiesController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PaystackController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('client/welcome');
// });


Auth::routes();

Route::get('/home',[ShopController::class, 'list'])->name('home');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'list']);

Route::prefix('cart')->group( function() {
    Route::post('/', [CartController::class,'post'])->name('post.cart');
    Route::post('/add-to-cart', [CartController::class,'addToCart']);
    Route::post('/update-cart', [CartController::class,'updateCart']);
    Route::get('/client/cart', [CartController::class,'index']);
    Route::post('/paystack', [PaystackController::class,'success']);
});


Route::prefix('checkout')->group( function() {
    Route::post('/', [CheckoutController::class, 'sendPayment'])->name('post.checkout');
    Route::post('/delivery', [CheckoutController::class, 'onDelivery'])->name('post.deliver');
    Route::post('/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/success', function () {
        return view('shop.order-success');
    });
});

Route::get('/orders', [OrderController::class,'list'])->name('orders');
Route::get('/order/{id}', [OrderController::class, 'getOrder'])->name('order');
Route::put('/order/status', [OrderController::class,'changeOrderStatus'])->name('change.order.status');

Route::prefix('shop')->group( function() {
    Route::get('/show-order/{id}', [ShopController::class, 'orders'])->name('shop.orders');
    Route::get('/show-order-data/{id}', [ShopController::class, 'order_data'])->name('shop.orders');
    Route::get('/', [ShopController::class,'list'])->name('shop');
    Route::get('/category/{id}', [ShopController::class, 'get_child_catalogs']);
    Route::get('/product/{id}', [ShopController::class, 'get_product'])->name('product');
    Route::get('/search', [ShopController::class, 'search','as' => 'search']);
    Route::any ( '/search', function (Request $request) {
            $search = $request->input('search');
            // ============== Seach program name ==============================
            $categories = Catalog::all();
            if($search!=="")
            {
                $products = Product::where('name', 'LIKE', "%{$search}%")->with('catalogs')->paginate(1);
                $pagination = $products->appends ( array (
                    'search' => $request->get('search')
                  ));

                    return view('client.search',['products'=>$products, 'categories'=>$categories, 'search'=>$search]);


            }



            // ================= Search School name ==========================
           } );

});


Route::post('filter', [PropertyController::class, 'filter']);

Auth::routes();

Route::prefix('admin')->group( function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/payments', [AdminController::class, 'payment'])->name('admin.payments');

    //Admin categories management
    Route::get('/categories', [AdminCategoriesController::class, 'list'])->name('admin.categories');
    Route::post('delete/category', [AdminCategoriesController::class, 'delete']);
    Route::get('/add-category', [AdminCategoriesController::class, 'showEditForm'])->name('add-category');
    Route::get('/edit-category/{id}', [AdminCategoriesController::class, 'showEditForm']);
    Route::post('/categories', [AdminCategoriesController::class, 'update']);
    Route::get('/fetch_category_details', [AdminCategoriesController::class, 'fetch_category_details']);

    //Admin products management
    Route::get('/products', [AdminProductsController::class, 'list'])->name('admin.products');
    Route::delete('/delete/product', [AdminProductsController::class, 'delete'])->name('product.delete');
    Route::get('/add-product', [AdminProductsController::class, 'showEditForm'])->name('add-product');
    Route::get('/edit-product/{id}', [AdminProductsController::class, 'showEditForm']);
    Route::post('/update_products', [AdminProductsController::class, 'update']);
    Route::get('/products/category/{id}', [AdminProductsController::class, 'categoryFilter']);
    Route::get('/fetch_product_details', [AdminProductsController::class, 'fetch_product_details']);

    //Admin add and remove products properties
    Route::delete('/product/{product_id}/property', [AdminProductsController::class, 'deleteProperty']);
    Route::get('/product/{product_id}/properties', [AdminProductsController::class, 'getProperties']);

    Route::get('/products/property-types', [AdminPropertiesController::class, 'getProperties']);
    Route::get('/products/property/{id}/values', [AdminPropertiesController::class,'getPropertyValues']);
    Route::post('/product/property-type', [AdminPropertiesController::class, 'addPropertyToProduct']);
    Route::post('/properties', [AdminPropertiesController::class, 'createProperty']);

    Route::get('/users', [AdminUsersController::class,'list'])->name('admin.users');
    Route::get('/edit-user/{id}', [AdminUsersController::class, 'showEditForm']);
    Route::put('/user', [AdminUsersController::class,'update'])->name('user.update');
    Route::post('/users', [AdminUsersController::class, 'search'])->name('users.search');
    Route::put('/users/', [AdminUsersController::class, 'deleteCart'])->name('cart.delete');

    Route::get('/orders', [AdminOrdersController::class, 'list'])->name('admin.orders');
    Route::get('/pending_orders', [AdminOrdersController::class, 'pending_orders'])->name('admin.pending_orders');
    Route::get('/show-order/{id}', [AdminOrdersController::class, 'showEditForm']);
    Route::put('/order', [AdminOrdersController::class, 'update'])->name('order.update');
    Route::post('/orders', [AdminOrdersController::class, 'search'])->name('order.search');

    Route::get('/shipping-methods', [AdminShippingMethodsController::class, 'list'])->name('admin.shipping-methods');
    Route::put('/shipping-method', [AdminShippingMethodsController::class, 'changeStatus']);

    Route::get('/list-admins', [AdminController::class, 'list_admins'])->name('admin.admins');

});

Route::get('/test', [TestController::class, 'test']);

Route::get('/debug-sentry', function () {
    throw new Exception('My Sentry error!');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
