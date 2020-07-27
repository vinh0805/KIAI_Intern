@extends('layout')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
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
        </div>
    </section> <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Cart Sub Total <span>{{Cart::subtotal()}} VND</span></li>
                            <li>Eco Tax <span>{{Cart::tax()}} VND</span></li>
                            <li>Shipping Cost <span>Free</span></li>
                            <li>Total <span>{{Cart::total()}} VND</span></li>
                        </ul>
                        @if(Session::get('customer_id') === null)
                            <a class="btn btn-default check_out" href="{{url('/login-checkout')}}">Check Out</a>
                        @else
                            <a class="btn btn-default check_out" href="{{url('/checkout')}}">Check Out</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->


@endsection
