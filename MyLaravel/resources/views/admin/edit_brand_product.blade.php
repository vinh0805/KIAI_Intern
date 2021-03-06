@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Update product's infomation
                </header>
                <?php
                $message = Session::get('message');
                if($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <div class="panel-body">
                    @foreach($editBrandProduct as $key => $editValue)
                        <div class="position-center">
                            <form role="form" action="{{URL::to('/update-brand-product/' . $editValue->brand_id)}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name of product</label>
                                    <input class="form-control" value="{{$editValue->brand_name}}" name="brand_product_name" id="productName" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Describe</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="brand_product_desc" id="brandDesc" value="{{$editValue->brand_desc}}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Display</label>
                                    <label for="exampleInputPassword1">Display</label>
                                    <select name="brand_product_status" class="form-control input-sm m-bot15">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <button type="submit" name="add_brand_product" class="btn btn-info">Edit</button>
                            </form>
                        </div>
                    @endforeach

                </div>
            </section>
        </div>

@endsection
