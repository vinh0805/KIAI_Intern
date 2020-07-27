<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index() {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '=', 1)
            ->orderBy('product_id', 'desc')->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('allProduct', $all_product);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keyword .'%')->get();

        return view('pages.product.search')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('search_product', $search_product);

    }
}
