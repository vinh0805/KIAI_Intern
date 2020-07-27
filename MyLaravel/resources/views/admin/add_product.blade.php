@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add product
                </header>
                <?php
                $message = Session::get('message');
                if($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input class="form-control" name="product_name" id="productName" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Category</label>
                                <select name="product_cate" class="form-control input-sm m-bot15">
                                    @foreach($cate_product as $key => $cate)
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Brand</label>
                                <select name="product_brand" class="form-control input-sm m-bot15">
                                    @foreach($brand_product as $key => $brand)
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Describe</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="productDescribe" placeholder="Describe product"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="productContent" placeholder="Content of product"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Price</label>
                                <input  class="form-control" name="product_price" id="productPrice">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Image</label>
                                <input class="form-control" type="file" name="product_image" id="productImage">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Display</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <button type="submit" name="add_product" class="btn btn-info">Add</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>

@endsection
