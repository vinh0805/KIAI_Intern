<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function authLogin()
    {
        $admin_id = Session::get('admin_id');
        if (isset($admin_id)) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function addProduct()
    {
        $this->authLogin();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderBy('brand_id', 'desc')->get();

        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }

    public function allProduct()
    {
        $this->authLogin();
        $allProduct = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->orderBy('tbl_product.product_id', 'desc')->get();
        $managerProduct = view('admin.all_product')->with('allProduct', $allProduct);
        return view('admin_layout')->with('allProduct', $managerProduct);
    }

    public function saveProduct(Request $request)
    {
        $this->authLogin();
        $data = [
            'product_name' => $request->product_name,
            'category_id' => $request->product_cate,
            'brand_id' => $request->product_brand,
            'product_desc' => $request->product_desc,
            'product_content' => $request->product_content,
            'product_price' => $request->product_price,
            'product_image' => $request->product_image,
            'product_status' => $request->product_status
        ];
        $get_image = $request->file('product_image');
        if ($get_image) {
            $new_image = $get_image->getClientOriginalName();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Add product successfully!!!');
            return Redirect::to('all-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Add product successfully!!!');
        return Redirect::to('all-product');
    }

    public function activeProduct($productId)
    {
        $this->authLogin();
        DB::table('tbl_product')->where('product_id', $productId)->update(['product_status'=>1]);
        Session::put('message', 'Change product\'s status successfully!!!');
        return Redirect::to('all-product');
    }

    public function unactiveProduct($productId)
    {
        $this->authLogin();
        DB::table('tbl_product')->where('product_id', $productId)->update(['product_status'=>0]);
        Session::put('message', 'Change product\'s status successfully!!!');
        return Redirect::to('all-product');
    }

    public function editProduct($productId)
    {
        $this->authLogin();
        $cateProduct = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brandProduct = DB::table('tbl_brand')->orderBy('brand_id', 'desc')->get();

        $editProduct = DB::table('tbl_product')->where('product_id', $productId)->get();
        $managerProduct = view('admin.edit_product')->with('editProduct', $editProduct)
            ->with('cateProduct', $cateProduct)->with('brandProduct', $brandProduct);
        return view('admin_layout')->with('admin.edit_product', $managerProduct);
    }

    public function updateProduct(Request $request, $productId)
    {
        $this->authLogin();
        $data = [
            'product_name' => $request->product_name,
            'category_id' => $request->product_cate,
            'brand_id' => $request->product_brand,
            'product_desc' => $request->product_desc,
            'product_content' => $request->product_content,
            'product_price' => $request->product_price,
            'product_status' => $request->product_status
        ];
        $get_image = $request->file('product_image');
        if ($get_image) {
            $new_image = $get_image->getClientOriginalName();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $productId)->update($data);
            Session::put('message', 'Update product successfully!!!');
            return Redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id', $productId)->update($data);
        Session::put('message', 'Update product successfully!!!');
        return Redirect::to('all-product');
    }

    public function deleteProduct($productId)
    {
        $this->authLogin();
        DB::table('tbl_product')->where('product_id', $productId)->delete();
        Session::put('message', 'Delete product successfully!!!');
        return Redirect::to('all-product');
    }

    public function detailProduct($productId)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        $detail_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->where('tbl_product.product_id', $productId)->get();

        $category_id = '';
        foreach ($detail_product as $key => $value) {
            $category_id = $value->category_id;
        }

        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->where('tbl_category_product.category_id', $category_id)
            ->whereNotIn('tbl_product.product_id', [$productId])->get();

        return view('pages.product.show_detail')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('detail_product', $detail_product)->with('relate', $related_product);
    }
}
