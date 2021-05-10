<!-- Add -->
<div class="modal fade" id="create">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="container">

                <div class="row ">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ni ni-fat-remove" style="color: black;"></i></span></button>
                    <div class="col-xl-12 d-flex justify-content-center align-items-stretch">
                        <h2 class="modal-title "><b>Add New Category

                            </b></h2><br>
                    </div>
                    <div class="col-xl-12  justify-content-center align-items-stretch">
                        <form action="{{url('/admin/categories/')}}" enctype="multipart/form-data"
                            class="form-horizontal" method="post" id="create-form">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" name="name" class="form-control" id="inputName"
                                        placeholder="Enter Category Name" required minlength="3" maxlength="30">
                                </div>

                                <!-- <div class="col-md-12 form-group">
                                    <label for="inputDescription">Description</label>
                                    <textarea  name="description" class="form-control" id="inputDescription"
                                        placeholder="Description"></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Priority</label>
                                    <input type="number" name="priority" class="form-control" id="inputPriority"
                                        max="99">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Parent</label>
                                    <select class="form-control" id="parent" name="parent">
                                        <option @if (!$category) selected @endif value="">No parent</option>
                                        @foreach( $parent_categories_names as $par_cat )
                                        <option value="{{$par_cat->id}}" @if ( $category && ($par_cat->id ==
                                            $category->parent_id) ) selected @endif>
                                            {{$par_cat->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> -->

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
                        <h2 class="modal-title name"><b>Add New Category

                            </b></h2><br>
                    </div>
                    <div class="col-xl-12  justify-content-center align-items-stretch">
                        <form action="{{url('/admin/categories/')}}" enctype="multipart/form-data"
                            class="form-horizontal" method="post" id="update-form">
                            @csrf
                            <input type="hidden" name="id" id="cat_id">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter Category Name" required minlength="3" maxlength="30">
                                </div>

                                <!-- <div class="col-md-12 form-group">
                                    <label for="inputDescription">Description</label>
                                    <textarea name="description" class="form-control" id="desc"
                                    placeholder="Description"> </textarea>
                                </div> -->

                                <!-- <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Priority</label>
                                    <input type="number" name="priority" class="form-control" id="priority"
                                    max="99">
                                </div> -->

                                <!-- <div class="col-md-6 form-group">
                                    <label for="inputPriority" class="col-sm-2 control-label">Parent</label>
                                    <select class="form-control" id="parent" name="parent">
                                        <option  selected value="" >No parent</option>
                                        @foreach( $parent_categories_names as $par_cat )
                                        <option value="{{$par_cat->id}}">
                                            {{$par_cat->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> -->

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
                                    <img id="image"
                                        alt="" class="img-thumbnail image" alt="Category image" width="200">
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
