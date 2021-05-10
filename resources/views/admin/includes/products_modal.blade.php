<!-- Add -->
<div class="modal fade" id="create">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="container">

                <div class="row ">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ni ni-fat-remove" style="color: black;"></i></span></button>
                    <div class="col-xl-12 d-flex justify-content-center align-items-stretch">
                        <h2 class="modal-title "><b>Add New Product

                            </b></h2><br>
                    </div>
                    <div class="col-xl-12  justify-content-center align-items-stretch">
                        <form action="{{url('/admin/products/')}}" enctype="multipart/form-data"
                            class="form-horizontal" method="post" id="create-form">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" name="name" class="form-control" id="inputName"
                                        placeholder="Enter Product Name" required minlength="3" maxlength="200">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputAva">Availability</label>
                                    <select name="availability" class="form-control">
                                    <option  value="In stock">In stock</option>
                                    <option value="Not in stock">Not in stock</option>
                                    </select>

                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputDescription">Description</label>
                                    <textarea type="text" name="description" class="form-control" id="inputDescription"
                                        placeholder="Description"></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Price</label>
`                                    <input type="number" name="price" class="form-control" id="inputPriority"
`                                        max="99">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option  value="">Select Category</option></option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">
                                    {{$category->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputFile">Select Image</label>
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse&hellip; <input type="file" accept="image/*"
                                                    data-preview="#preview" name="image" id="inputFile"
                                                    style="display: none;" alt="">
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <span class="help-block">
                                        The image must be jpeg/jpg/gif/png/svg less than 2Mb
                                    </span>
                                    <img id="blah" src="" alt="" class="img-thumbnail" alt="Category image" width="200">
                                </div>



                            </div>
                    </div>
                    <div class="col-xl-12 d-flex justify-content-center align-items-stretch">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button id="submit_details" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i>
                            Save</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



<!-- Edit  -->


<!-- Add -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="container">

                <div class="row ">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ni ni-fat-remove" style="color: black;"></i></span></button>
                    <div class="col-xl-12 d-flex justify-content-center align-items-stretch">
                        <h2 class="modal-title name" ><b>Edit Product

                            </b></h2><br>
                    </div>
                    <div class="col-xl-12  justify-content-center align-items-stretch">
                        <form action="{{url('/admin/products/')}}" enctype="multipart/form-data"
                            class="form-horizontal" method="post" id="update-form">
                            @csrf
                            <input id="prod_id" type="hidden" name="id" >
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter Product Name" required minlength="3" maxlength="200">
                                </div><br>

                                <div class="col-md-6 form-group">
                                    <label for="desc">Description</label>
                                    <textarea   name="description" class="form-control" id="desc"
                                        placeholder="Description" required></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Price</label>
`                                    <input type="number" name="price" class="form-control" id="price"
`                                        max="99" required>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Category</label>
                                    <select class="form-control" name="category" required>
                                        <option selected class="category" id="category_id"  >Select Category</option></option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">
                                    {{$category->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputFile">Select Image</label>
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse&hellip; <input type="file" accept="image/*"
                                                    data-preview="#preview" name="image" id="updateFile"
                                                    style="display: none;" alt="">
                                            </span>
                                        </label>
                                        <input id="input_image" type="text" class="form-control" readonly>
                                    </div>
                                    <span class="help-block">
                                        The image must be jpeg/jpg/gif/png/svg less than 2Mb
                                    </span>
                                    <img id="image" src="" alt="" class="img-thumbnail" alt="Product image" width="200">
                                </div>



                            </div>
                    </div>
                    <div class="col-xl-12 d-flex justify-content-center align-items-stretch">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button id="update_details" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i>
                            Save</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
