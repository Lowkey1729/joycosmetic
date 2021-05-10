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
    <title>{{ config('app.name', 'Joycosmetics') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/core-img/logo.png')}}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lora|Material+Icons" rel="stylesheet">


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
    <!--  Catagories Area Start -->
    <div class="products-catagories-area clearfix">
        <div class='img-edit-1'>
            <section class='hero-header-text'>
                <img class="img-edit">
                <h3 style="color: #fff; margin-top: 1.5em; font-family: 'Lora';">Welcome to Joy
                    Cosmetics </h3>
                <p style="color: #fff;">Get your <span class="txt-rotate" data-period="2000"
                        data-rotate='[ "sextoys ", " sex enhancement products "]'></span> at a very affordable price
                </p>
                <a href="{{url('/register')}}" class="btn btn-warning" style="background-color:#05001b; color:#fff;">Register and sale with Joycosmetics</a>
            </section>
        </div>

        
        <!-- Products area starts -->
        <h4 align="center" style="margin: 1em; font-weight: bolder;">Available Products</h4>
        <hr>
        <div class="amado-pro-catagory clearfix">

            <!-- Single Catagory -->
            @foreach($products as $product)

            <div class="">
                <div class="single-products-catagory ">
                    <a href="{{url('/shop/product/'.$product->id)}}" style="display: table-cell;">
                        <img class=" img-thumbnail img" style="object-fit: cover;"
                            src="{{url('images/'.$product->image)}}" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>&#8358;{{number_format($product->price)}}</h4>
                            <div class="line"></div>
                            <!-- <h4>{{$product->name}}</h4> -->
                        </div>
                    </a>
                    <!-- Ratings & Cart -->
                    <div class="ratings-cart text-center">
                        <div class="ratings">
                            <i style="color: #491fca" class="fa fa-star" aria-hidden="true"></i>
                            <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                            <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                            <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                            <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                        </div>

                    </div>
                    <h6 align="center">{{$product->name}}(&#8358;{{number_format($product->price)}})</h6>
                    <form class="cart clearfix" method="post" action="{{url('/cart/add-to-cart')}}">
                        @csrf
                        <input type="hidden" name="productQty" value="1">
                        <input type="hidden" name="productId" value="{{$product->id}}">
                        <button style="background-color: #0c010c;" class="btn btn-primary btn-block">Add to cart <img
                                src="{{asset('img/core-img/cart.png')}}" alt=""></button>
                    </form>
                </div>
            </div>

            @endforeach

        </div>
        {!!$products->links()!!}
        <!-- Products area stops -->
        
        <h4 align="center" style="margin: 1em; font-weight: bolder;">Categories</h4>
        <hr>
        <div class="amado-pro-catagory clearfix">

            
            <!-- Single Catagory -->
            <div class="">
                @foreach($categories as $category)
                <div style="background-color:#000;">
                    <div class="single-products-catagory ">
                        <a href="{{url('/shop/category/'.$category->id)}}" style="display: table-cell;">
                            <img class="img-thumbnail img" style="object-fit: cover; " src="{{url($category->image)}}"
                                alt="">
                            <!-- Hover Content -->
                            <div class="hover-content">
                                <div class="line"></div>
                                <h4>{{$category->name}}</h4>
                            </div>
                        </a>
                    </div>
                </div>

                @endforeach
            </div>




        </div>

        <!-- Categories Area stops -->


    </div>
    </div>

    <!-- ##### Main Content Wrapper End ##### -->
    <div class="container">

    </div>
    <!-- footer  -->
    @include('layouts.footer')
    <!-- footer -->


    <script>
    var TxtRotate = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtRotate.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

        var that = this;
        var delta = 300 - Math.random() * 100;

        if (this.isDeleting) {
            delta /= 2;
        }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function() {
            that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('txt-rotate');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-rotate');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtRotate(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
        document.body.appendChild(css);
    };
    </script>
