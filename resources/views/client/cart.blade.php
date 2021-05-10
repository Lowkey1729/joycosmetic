<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>{{ config('app.name', 'Product | Joy Cosmetics') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/core-img/logo.png')}}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lora|Material+Icons" rel="stylesheet">
    <!-- Favicon  -->
    <link rel="icon" href="{{asset('img/core-img/kooo.png')}}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{asset('css/client/core-style.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/style.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

</head>
<style>
body {
    font-family: "Lora";
    font-weight: 400;

}



.img {
    float: left;
    width: 100px;
    height: 200px;

}





.img-edit-1 {

    height: 300px;
    width: 100%;
    top: 40%;
    text-align: center;
    background: black;
    overflow: hidden;
    background: #030303;
    /* fallback colour. Make sure this is just one solid colour. */
    background: -webkit-linear-gradient(rgba(29, 38, 113, 0.8), rgba(21, 14, 16, 0.8)), url("img/core-img/1.jpg");
    /* background: linear-gradient(rgba(29, 38, 113, 0.8), rgba(195, 55, 100, 0.8)), url("https://bit.ly/2rlzaXi"); The least supported option. */
}

.img-edit {
    opacity: 0.4;
}
</style>

<body>
    <!-- nav -->
    @include('layouts.nav')
    <!-- nav -->

    <!-- Header Area Start -->
    @include('layouts.header')
    <!-- Header Area End -->

    <!-- Cart section -->
    <div class="cart-table-area section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="cart-title mt-50">
                        <h2>Shopping Cart</h2>
                    </div>

                    <div class=" table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th colspan="2">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($product_carts as $key=>$product_cart)
                                <tr>
                                    <td class="cart_product_img">
                                        <a href="#"><img src="{{url('images/'.$product_cart->image)}}"
                                                alt="Product"></a>
                                    </td>
                                    <td class="cart_product_desc">
                                        <h5>{{$product_cart->name}}</h5>
                                    </td>
                                    <td class="price">
                                        <span id="price{{$key+1}}">&#8358;{{number_format($product_cart->price)}}</span>
                                    </td>

                                    <td class="qty">
                                        <button class="btn" id="remove" data-id="{{$product_cart->id}}"
                                            style="font-weight: bolder; font-size: 1.2em;">&times;</button>
                                        <div class="qty-btn d-flex">
                                            <p>Qty</p>
                                            <div class="quantity">
                                                <span class="qty-minus sub_qty" data-id="{{$product_cart->id}}"
                                                    data-qty="{{$product_cart->qty}}"
                                                    onclick="var effect = document.getElementById('qty{{$key+1}}' ); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i
                                                        class="fa fa-minus sub_qty" aria-hidden="true"
                                                        data-id="{{$product_cart->id}}"
                                                        data-qty="{{$product_cart->qty}}"></i></span>
                                                <input type="number" class="qty-text" id="qty{{$key+1}}" step="1"
                                                    min="1" max="300" name="quantity" value="{{$product_cart->qty}}">
                                                <span class="qty-plus add_qty" data-id="{{$product_cart->id}}"
                                                    data-qty="{{$product_cart->qty}}"
                                                    onclick="var effect = document.getElementById('qty{{$key+1}}' ); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i
                                                        class="fa fa-plus add_qty" aria-hidden="true"
                                                        data-id="{{$product_cart->id}}"
                                                        data-qty="{{$product_cart->qty}}"></i></span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <h4 align="center">Your cart is empty</h4>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(!empty($product_carts))
                <div class="col-12 col-lg-4">
                    <div class="cart-summary">
                        <h5>Cart Total</h5>
                        <ul class="summary-table">
                            <li><span>subtotal:</span> <span class="total_val">&#8358;0.00</span></li>
                            <li><span>delivery:</span> <span>Free</span></li>
                            <li><span>total:</span> <span class="total_val">&#8358;0.00</span></li>
                        </ul>
                        <div class="cart-btn mt-100">
                            <form method="POST" action="{{url('checkout/')}}" id="order-form">
                                @csrf
                                @if(isset(Auth::user()->email))
                                <input type="hidden" name="email" id="email" value="{{Auth::user()->email}}">
                                @endif
                                @foreach($product_carts as $product_cart)
                                <input type="hidden" name="productId" value="{{json_encode($product_carts)}}">
                                @endforeach
                                <input type="hidden" id="total_val" name="subtotal">
                                <button @if(isset(Auth::user()->email)) id="submit_order"  @endif class="btn amado-btn w-100"
                                    style="background-color: #0c010c;">
                                    Checkout
                                </button><hr>

                                <button @if(isset(Auth::user()->email)) id="submit_order_delivery"  @endif class="btn amado-btn w-100"
                                    style="background-color: #0c010c;">
                                    Pay on delivery
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>





    </div>
    </div>
    <!-- footer  -->
    @include('layouts.footer')
    <!-- footer -->
    <script src="https://js.paystack.co/v1/inline.js"></script>,
    <script>
    $(document).ready(function() {
        var total = 0;
        var product_carts = <?php echo json_encode($product_carts)?>;
        product_carts.forEach(getTotal);
        console.log(product_carts);

        function getTotal(item, index, arr) {
            total += arr[index].qty * arr[index].price;
            $('.total_val').html('&#8358;' + new Intl.NumberFormat().format(total));
            $('#total_val').val(total);
            console.log(total);

        }


    });

    $(document).on('click', '#remove', function() {
        var id = $(this).data('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('/cart/')}}",
            method: "POST",
            data: {
                productId: id,
                input: 'removeRow'
            },
            complete: function(response) {
                console.log(response);
            },
            success: function(result) {
                alert('Product removed');
                location.reload();
            }
        })
    });

    $(document).on('click', '.add_qty', function() {
        var id = $(this).data('id');
        var qty = $(this).data('qty') + 1;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('/cart/update-cart')}}",
            method: "POST",
            data: {
                productId: id,
                input: 'updateQty',
                productQty: qty
            },
            complete: function(response) {
                console.log(response);
            },
            success: function(result) {
                alert('Quantity added');
                location.reload();
            }
        })
    });


    $(document).on('click', '.sub_qty', function() {
        var id = $(this).data('id');
        var qty = $(this).data('qty');
        if (qty == 1) {
            qty = $(this).data('qty');
        } else {
            qty = $(this).data('qty') - 1;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('/cart/update-cart')}}",
            method: "POST",
            data: {
                productId: id,
                input: 'updateQty',
                productQty: qty
            },
            complete: function(response) {
                console.log(response);
            },
            success: function(result) {
                alert('Quantity reduced');
                location.reload();
            }
        })
    });



    // Payment via paystack

    $(document).on('click', '#submit_order', function(e) {
        e.preventDefault();
        email = document.getElementById("email").value;
        amount = document.getElementById("total_val").value;
        $('#submit_order').html("Submiting Order...");
        payWithPaystack(email, amount);


    });

    $(document).on('click', '#submit_order_delivery', function(e) {
        e.preventDefault();
        email = document.getElementById("email").value;
        amount = document.getElementById("total_val").value;
        $('#submit_order_delivery').html("Submiting Order...");

        submitOrderDelivery();

    });

    var paymentForm = document.getElementById('order-form');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack() {
        var total_amount = document.getElementById("total_val").value * 100;
        var handler = PaystackPop.setup({
            key: 'pk_test_d14ae70c7ad02c11e1794e7aad32041ee0636a9b', // Replace with your public key
            email: document.getElementById("email").value,
            currency: "NGN",
            amount: total_amount,
            reference: <?php echo random_int(9999,9999999) ?>, // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            // label: "Optional string that replaces customer email"
            onClose: function() {
                alert('Window closed.');
                $('#submit_order').html("Checkout");
            },
            callback: function(response) {
                var reference = response.reference;

                $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                    url: "{{url('cart/paystack')}}",
                    method: "POST",
                    data: {
                        'amount': document.getElementById("total_val").value,
                        'reference': reference
                    },
                    complete: function(response) {

                       console.log(response);


                    },
                    success: function(response) {
                        submitOrder();


                        // the transaction status is in response.data.status
                    }
                });
            },

            onClose: function() {
                alert('window closed');
            }
        });
        handler.openIframe();
    }

     function  submitOrder()
     {
        var form = $("#order-form");
        var formData = new FormData(form[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('checkout/')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            complete: function(response) {
                $('#submit_order').html("Checkout");

                console.log(response);
            },
            success: function(result) {
                if (result === "done") {
                    alert('Order  placed successfully.');
                    location.reload();
                }


            }
        });
     }



     function  submitOrderDelivery()
     {
        var form = $("#order-form");
        var formData = new FormData(form[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('checkout/delivery/')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            complete: function(response) {
                $('#submit_order').html("Checkout");

                console.log(response);
            },
            success: function(result) {
                if (result === "done") {
                    alert('Order  placed successfully.');
                    location.reload();
                }


            }
        });
     }
    </script>
