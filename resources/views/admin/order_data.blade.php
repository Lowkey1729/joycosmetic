@include('admin.section.header')
@include('admin.section.sidebar')
@include('admin.section.navbar')

<!--************************ details***************************************** -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0"></h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <!-- <a href="#" class="btn btn-sm btn-neutral">New</a>
              <a href="#" class="btn btn-sm btn-neutral">Filters</a> -->
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">ORDERS</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$counts}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <img src="{{ asset('css/admin/assets/img/icons/common/group.png') }}"
                                            width="30px">&nbsp;
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">

                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="col-xl-12 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1"
                                    class=" table  table-bordered align-items-center table-flush table-dark">
                                    <thead>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Created</th>
                                    </thead>

                                    <tbody>

                                        @foreach($orders as $key=>$order)
                                        <tr>
                                            <td style="color: #000000; font-weight:bold;">{{$key+1}}</td>
                                            <td style="color: #000000; font-weight:bold;">{{$order->product->name}}</td>
                                            <td style="color: #000000; font-weight:bold;"><img src="{{ url('images/'.$order->product->image) }}"
                                                    class="img-thumbnail" alt="image" width="152" height="118"></td>
                                            <td style="color: #000000; font-weight:bold;">&#8358;{{number_format($order->price)}}</td>
                                            <td style="color: #000000; font-weight:bold;">{{$order->qty}}</td>
                                            <td style="color: #000000; font-weight:bold;">
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
</div>
</div>

@include('admin.section.footer')
