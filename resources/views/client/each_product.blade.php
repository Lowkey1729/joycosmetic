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

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lora|Material+Icons" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/core-img/logo.png')}}" type="image/png">
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

    <!-- Product Area starts -->
    <div class="single-product-area section-padding-100 clearfix">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-50">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{url('/shop/category/'.$product->catalogs->id)}}">{{$product->catalogs->name}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a class="gallery_img" href="{{url('images/'.$product->image)}}">
                                        <img class="d-block w-100" src="{{url('images/'.$product->image)}}"
                                            alt="First slide">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="single_product_desc">
                        <!-- Product Meta Data -->
                        <div class="product-meta-data">
                            <div class="line"></div>
                            <p class="product-price" style="color: #491fca">&#8358;{{number_format($product->price)}}
                            </p>
                            <a href="product-details.html">
                                <h6>{{$product->name}}</h6>
                            </a>
                            <!-- Ratings & Review -->
                            <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                <div class="ratings">
                                    <i style="color: #491fca" class="fa fa-star" aria-hidden="true"></i>
                                    <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                                    <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                                    <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                                    <i style="color: #491fca;" class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="review">
                                    <!-- <a href="#">Write A Review</a> -->
                                </div>
                            </div>
                            <!-- Avaiable -->
                            <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>
                        </div>

                        <div class="short_overview my-5">
                            <p>{!!$product->description!!}</p>
                        </div>

                        <!-- Add to Cart Form -->
                        <form class="cart clearfix" method="post" action="{{url('/cart/add-to-cart')}}">
                            @csrf
                            <input type="hidden" name="productId" value="{{$product->id}}">
                            <div class="cart-btn d-flex mb-50">
                                <p>Qty</p>
                                <div class="quantity">
                                    <span class="qty-minus"
                                        onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i
                                            class="fa fa-caret-down" aria-hidden="true"></i></span>
                                    <input type="number" class="qty-text" id="qty" step="1" min="1" max="300"
                                        name="productQty" value="1">
                                    <span class="qty-plus"
                                        onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i
                                            class="fa fa-caret-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="btn amado-btn" style="background-color: #0c010c;">Add to
                                cart</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>





    </div>
    </div>
    <!-- footer  -->
    @include('layouts.footer')
    <!-- footer -->
