<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
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

    public function addBrandProduct()
    {
        $this->authLogin();
        return view('admin.add_brand_product');
    }

    public function allBrandProduct()
    {
        $this->authLogin();
        $allBrandProduct = DB::table('tbl_brand')->get();
        $managerBrandProduct = view('admin.all_brand_product')->with('allBrandProduct', $allBrandProduct);
        return view('admin_layout')->with('allBrandProduct', $managerBrandProduct);
    }

    public function saveBrandProduct(Request $request)
    {
        $this->authLogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;
        $data['brand_status'] = $request->brand_product_status;

        DB::table('tbl_brand')->insert($data);
        Session::put('message', 'Add product successfully!!!');
        return Redirect::to('add-brand-product');
    }

    public function activeBrandProduct($brandProductId)
    {
        $this->authLogin();
        DB::table('tbl_brand')->where('brand_id', $brandProductId)->update(['brand_status'=>1]);
        Session::put('message', 'Change product\'s status successfully!!!');
        return Redirect::to('all-brand-product');
    }

    public function unactiveBrandProduct($brandProductId)
    {
        $this->authLogin();
        DB::table('tbl_brand')->where('brand_id', $brandProductId)->update(['brand_status'=>0]);
        Session::put('message', 'Change product\'s status successfully!!!');
        return Redirect::to('all-brand-product');
    }

    public function editBrandProduct($brandProductId)
    {
        $this->authLogin();
        $editBrandProduct = DB::table('tbl_brand')->where('brand_id', $brandProductId)->get();
        $managerBrandProduct = view('admin.edit_brand_product')->with('editBrandProduct', $editBrandProduct);
        return view('admin_layout')->with('admin.edit_brand_product', $managerBrandProduct);
    }

    public function updateBrandProduct(Request $request, $brandProductId)
    {
        $this->authLogin();
        $data = [
            'brand_name' => $request->brand_product_name,
            'brand_desc' => $request->brand_product_desc,
            'brand_status' => $request->brand_product_status
        ];

        DB::table('tbl_brand')->where('brand_id', $brandProductId)->update($data);
        Session::put('message', 'Update product successfully!!!');
        return Redirect::to('all-brand-product');
    }

    public function deleteBrandProduct($brandProductId)
    {
        $this->authLogin();
        DB::table('tbl_brand')->where('brand_id', $brandProductId)->delete();
        Session::put('message', 'Delete product successfully!!!');
        return Redirect::to('all-brand-product');
    }
    // End function Admin Page

    public function showBrandHome($brandId)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();
        $brand_by_id = DB::table('tbl_product')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->where('tbl_brand.brand_id', $brandId)->get();
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id', $brandId)->first();

        return view('pages.brand.show_brand')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('brand_by_id', $brand_by_id)->with('brand_name', $brand_name);
    }


}
