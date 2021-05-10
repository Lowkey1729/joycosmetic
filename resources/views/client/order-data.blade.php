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
    <title>{{ config('app.name', 'Orders | Joy Cosmetics') }}</title>
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
                <div class="col-12 col-lg-12">
                    <div class="cart-title mt-50">
                        <h2>Orders</h2>
                    </div>

                    <div class=" table-responsive">
                        <table  style="width:50%" id="example1" class="table">
                                    <thead>
                                        <th >Id</th>
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Created</th>
                                    </thead>

                                    <tbody>

                                        @foreach($orders as $key=>$order)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$order->product->name}}</td>
                                            <td><img src="{{ url('images/'.$order->product->image) }}"
                                                    class="img-thumbnail" alt="image" width="152" height="118"></td>
                                            <td>&#8358;{{number_format($order->price)}}</td>
                                            <td>{{$order->qty}}</td>
                                            <td>
                                               {{$order->created_at->format('Y-M-d h:i')}}
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                        </table>
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
    <script >
  $(function()
  {
    $('#example1').DataTable({
      responsive: true
    });
    $('#example2').DataTable({
      responsive: true
    });
  });
</script>
  

