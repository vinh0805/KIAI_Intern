@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit product
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
                        @foreach($editProduct as $key => $pro)
                        <form role="form" action="{{URL::to('/update-product/' . $pro->product_id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input class="form-control" name="product_name" id="productName" value="{{$pro->product_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Category</label>
                                <select name="product_cate" class="form-control input-sm m-bot15">
                                    @foreach($cateProduct as $key => $cate)
                                        @if($cate->category_id == $pro->category_id)
                                            <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @else
                                            <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Brand</label>
                                <select name="product_brand" class="form-control input-sm m-bot15">
                                    @foreach($brandProduct as $key => $brand)
                                        @if($brand->brand_id == $pro->brand_id)
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @else
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Describe</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="productDescribe">
                                    {{$pro->product_desc}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="productContent">
                                    {{$pro->product_content}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Price</label>
                                <input  class="form-control" name="product_price" id="productPrice" value="{{$pro->product_price}}">
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
                            <button type="submit" name="add_product" class="btn btn-info">Update</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>
        </div>

@endsection
