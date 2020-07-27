@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Payment</li>
                </ol>
            </div><!--/breadcrums-->

            <div class="review-payment">
                <h2>Review & Payment</h2>
            </div>

            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Cart::content() as $content)
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{url('/public/upload/product/' . $content->options->image)}}"
                                                width="50px" height="50px" alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$content->name}}</a></h4>
                                <p>Web ID: 1089772</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($content->price)}} VND</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{url('/update-cart-quantity')}}" method="POST">
                                        {{csrf_field()}}
                                        <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$content->qty}}" autocomplete="off" size="2">
                                        <input type="hidden" value="{{$content->rowId}}" name="rowId_cart" class="form-control">
                                        <input type="submit" value="Update" name="update_qty" class="btn btn-default btn-sm">
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">{{number_format($content->price*$content->qty)}} VND</p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{url('/delete-to-cart/' . $content->rowId)}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="review-payment">
                <h2>Choose payment method:</h2>
            </div>
            <form action="{{url('/order-place')}}" method="post">
                {{csrf_field()}}
                <div class="payment-options">
                    <span>
                        <label><input type="checkbox" name="payment_option" value="1"> Direct Bank Transfer</label>
                    </span>
                    <span>
                        <label><input type="checkbox" name="payment_option" value="2"> Cash</label>
                    </span>
                    <span>
                        <label><input type="checkbox" name="payment_option" value="3"> ATM Card</label>
                    </span>
                </div>
                <button type="submit" name="send_order_place" class="btn btn-primary">Order</button>
            </form>
        </div>
    </section> <!--/#cart_items-->

@endsection
