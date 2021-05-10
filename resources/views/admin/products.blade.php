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
                                    <h5 class="card-title text-uppercase text-muted mb-0">PRODUCTS</h5>
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
                                <span class="text-success mr-2"><button class="btn btn-secondary create">Add New
                                        Product</button></span>

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
                                        <th>Image</th>
                                        <th>Product Description</th>
                                        <th>Product Price</th>
                                        <th>Category</th>
                                        <th>Tools</th>
                                    </thead>

                                    <tbody>

                                        @foreach($products as $key=>$product)
                                        <tr>
                                            <td style="color: #000000; font-weight:bold;">{{$key+1}}</td>
                                            <td style="color: #000000; font-weight:bold;">{{$product->name}}</td>
                                            <td style="color: #000000; font-weight:bold;"> <img src="{{ url('images/'.$product->image) }}" class="img-thumbnail"
                                                    alt="image" width="152" height="118"></td>
                                            <td style="color: #000000;">{!!$product->description!!}</td>
                                            <td style="color: #000000; font-weight:bold;">&#8358;{{number_format($product->price)}}</td>
                                            <td style="color: #000000; font-weight:bold;">{{$product->catalogs->name}}</td>
                                            <td style="color: #000000; font-weight:bold;">
                                                <button class="btn btn-success edit btn-flat"
                                                    data-id="{{$product->id}}">
                                                    <i class="fa fa-edit">Edit</i></button>

                                                    <button class="btn btn-warning delete btn-flat"
                                                    data-id="{{$product->id}}">
                                                    <i class="fa fa-trash">Delete</i></button>
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

@include('admin.includes.products_modal')
@include('admin.section.footer')

<script>
//  js to run categories modal
$(function() {
    // Create
    $(document).on('click', '.create', function(e) {
        e.preventDefault();
        $('#create').modal('show');
    });

    // Edit
    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
    });

    //delete
    $(document).on('click', '.delete', function(e) {
        var id = $(this).data('id');
        var confirm = window.confirm("Are sure you want to delete this category?"+id);
        if(confirm)
        {

            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
               url: "{{url('/admin/delete/product')}}" ,
               method: "DELETE",
               data: {id:id},
               complete: function(response){
                   console.log(response);
                $('.delete').html("Delete");
               },
               success:function(result){
                console.log(result);
                if(result ==="failed")
                {
                    alert('Failed');
                }
                else{
                    alert('Product Deleted');
                    location.reload();
                }

               }
           })


        }
        else{
            alert('failed');
        }

});




    // Submit details for cretaing new ategory
    $(document).on('click', '#submit_details', function(e) {
        e.preventDefault();
        for ( instance in CKEDITOR.instances )
        CKEDITOR.instances["inputDescription"].updateElement();
        let data = $("#create-form").serialize();
            var form = $("#create-form");
            var formData = new FormData(form[0]);
            $('#submit_details').html("Saving...");
           $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
               url: "{{url('/admin/update_products/')}}" ,
               method: "POST",
               data: formData,
               processData: false,
               contentType: false,
               complete: function(response){
                console.log(response);
                $('#submit_details').html("Save");
               },
               success:function(result){
                   alert('Product uploaded');
                    location.reload();
               }
           })

    });

    //  Updating category
    $(document).on('click', '#update_details', function(e) {
        e.preventDefault();
        for ( instance in CKEDITOR.instances )
        CKEDITOR.instances["desc"].updateElement();
        let data = $("#update-form").serialize();
            var form = $("#update-form");
            var formData = new FormData(form[0]);
            $('#update_details').html("Saving...");
           $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
               url: "{{url('/admin/update_products/')}}" ,
               type: "POST",
               data: formData,
               enctype: 'multipart/form-data',
               processData: false,
               contentType: false,
               complete: function(response){
                   console.log(response);
                $('#update_details').html("Save");
               },
               success:function(response){
                    alert('Product Updated');
                    location.reload();
               }
           })

    });

    function getRow(id){
        $.ajax({
            type: 'GET',
            url: '{{ url("admin/fetch_product_details") }}',
            data: {id:id},
            dataType: 'json',
            success: function(response){
            $('.name').html(response.name);
            $('#name').val(response.name);
            $('#prod_id').val(response.prod_id);

            var filepath = response.prod_image;
            var filenameWithExtension = filepath.replace(/^.*[\\\/]/, '');
            $('#input_image').val(filenameWithExtension);
            document.getElementById('image').src='/images/'+response.image;
            $('#price').val(response.price);
            $('#category_id').val(response.cat_id);
            $('.category').html(response.cat_name);
            CKEDITOR.instances["desc"].setData(response.description);
            console.log(response);

            }
        });
        }

});
</script>


