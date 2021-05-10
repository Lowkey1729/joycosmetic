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
    <title>{{ config('app.name', 'Categories| Joy Cosmetics') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/core-img/logo.png')}}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lora|Material+Icons" rel="stylesheet">
    <!-- Favicon  -->


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
        <h4 align="center" style="margin: 1em; font-weight: bolder;">{{$catalogs->name}}</h4>
        <hr>



        <!-- Products area starts -->
        <h4 align="center" style="margin: 1em; font-weight: bolder;">Available Products</h4>
        <!-- ##### Single Widget ##### -->
        <!-- <div class="widget price mb-50">
            Widget Title
            <div class="col-6">
                <h6 class="widget-title mb-30">Price</h6>

                <div class="widget-desc">
                    <div class="slider-range">
                        <div data-min="50" data-max="300000" data-unit="&#8358;"
                            class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                            data-value-min="50" data-value-max="300000" data-label-result="" >
                            <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                        </div>
                        <div class="range-price">&#8358;500 - &#8358;{{number_format('300000')}}</div>
                    </div>
                </div>
            </div>

        </div> -->

        <div class="amado-pro-catagory clearfix">

            <!-- Single Catagory -->
            @forelse($products as $product)

            <div class="">
                <div class="single-products-catagory " data-cat="{{$product->price}}">
                    <a href="{{url('/shop/product/'.$product->id)}}" style="display: table-cell;">
                        <img class=" img-thumbnail img" style="object-fit: cover;"
                            src="{{url('images/'.$product->image)}}" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <h4>&#8358;{{number_format($product->price)}}</h4>
                            <div class="line"></div>
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
            @empty
            <h6 align="center">No Products for this category</h6>
            @endforelse


        </div>
        {!!$products->links()!!}
        <!-- Products area stops -->
    </div>
    </div>

    <!-- ##### Main Content Wrapper End ##### -->

    <!-- footer  -->
    @include('layouts.footer')
    <!-- footer -->
