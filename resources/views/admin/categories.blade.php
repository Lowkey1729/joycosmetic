@include('admin.section.header')
@include('admin.section.sidebar')
@include('admin.section.navbar')

<style>
td
{
color: #000000;
}
</style>
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
                                    <h5 class="card-title text-uppercase text-muted mb-0">CATEGORIES</h5>
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
                                        Category</button></span>

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
                                        <th>Category Name</th>
                                        <th>Image</th>
                                        <th>Category Priority</th>
                                        <th>Parent Name</th>
                                        <th>Tools</th>
                                    </thead>

                                    <tbody>

                                        @foreach($categories as $key=>$category)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td style="color: #000000; font-weight:bold;">{{$category->name}}</td>
                                            <td> <img src="{{ url($category->image) }}" class="img-thumbnail"
                                                    alt="image" width="152" height="118"></td>
                                            <td>{{$category->priority}}</td>
                                            <td>{{$category->parent_name}}</td>
                                            <td>
                                                <button class="btn btn-success edit btn-flat"
                                                    data-id="{{$category->id}}">
                                                    <i class="fa fa-edit">Edit</i></button>

                                                    <button class="btn btn-warning delete btn-flat"
                                                    data-id="{{$category->id}}">
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

@include('admin.includes.categories_modal')
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
               url: "{{url('/admin/delete/category')}}" ,
               method: "POST",
               data: {id:id},
               complete: function(response){
                   console.log(response);
                $('.delete').html("Delete");
               },
               success:function(result){
                console.log(result);
                if(result ==="failed")
                {
                    alert('Category  has parents');
                }
                else{
                    alert('Category Deleted');
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
               url: "{{url('/admin/categories/')}}" ,
               method: "POST",
               data: formData,
               processData: false,
               contentType: false,
               complete: function(){
                $('#submit_details').html("Save");
               },
               success:function(result){
                   alert('Category uploaded');
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
               url: "/admin/categories/" ,
               type: "POST",
               data: formData,
               enctype: 'multipart/form-data',
               processData: false,
               contentType: false,

               complete: function(response){
                $('#update_details').html("Save");
               },
               success:function(response){
                   console.log(response);
                    alert('Category Updated');
                    location.reload();
               }
           })

    });

    function getRow(id){
        $.ajax({
            type: 'GET',
            url: '{{ url("admin/fetch_category_details") }}',
            data: {id:id},
            dataType: 'json',
            success: function(response){
            $('.name').html(response.name);
            $('#name').val(response.name);
            $('#cat_id').val(response.id);

            var filepath = response.image;
            var filenameWithExtension = filepath.replace(/^.*[\\\/]/, '');
            $('#input_image').val(filenameWithExtension);
            document.getElementById('image').src='/'+response.image;
            $('#priority').val(response.priority);
            $('#parent').val(response.parent);
            $('.parent').html(response.parent);
            CKEDITOR.instances["desc"].setData(response.description);
            console.log(response);

            }
        });
        }

});
</script>


