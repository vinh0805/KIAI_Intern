<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function saveCart(Request $request)
    {
        $product_id = $request->product_id_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id', $product_id)->first();

        $data['id'] = $product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;

        Cart::add($data);
        return redirect('/show-cart');

    }

    public function showCart()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product);
    }

    public function deleteToCart($rowId)
    {
        Cart::update($rowId, 0);
        return redirect('/show-cart');
    }

    public function updateCartQuantity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return redirect('/show-cart');
    }
}
