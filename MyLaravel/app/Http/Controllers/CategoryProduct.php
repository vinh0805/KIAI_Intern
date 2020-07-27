<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
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

    public function addCategoryProduct()
    {
        $this->authLogin();
        return view('admin.add_category_product');
    }

    public function allCategoryProduct()
    {
        $this->authLogin();
        $allCategoryProduct = DB::table('tbl_category_product')->get();
        $managerCategoryProduct = view('admin.all_category_product')->with('allCategoryProduct', $allCategoryProduct);
        return view('admin_layout')->with('allCategoryProduct', $managerCategoryProduct);
    }

    public function saveCategoryProduct(Request $request)
    {
        $this->authLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message', 'Add product category successfully!!!');
        return Redirect::to('add-category-product');
    }

    public function activeCategoryProduct($categoryProductId)
    {
        $this->authLogin();
        DB::table('tbl_category_product')->where('category_id', $categoryProductId)->update(['category_status'=>1]);
        Session::put('message', 'Change product category\'s status successfully!!!');
        return Redirect::to('all-category-product');
    }

    public function unactiveCategoryProduct($categoryProductId)
    {
        $this->authLogin();
        DB::table('tbl_category_product')->where('category_id', $categoryProductId)->update(['category_status'=>0]);
        Session::put('message', 'Change product category\'s status successfully!!!');
        return Redirect::to('all-category-product');
    }

    public function editCategoryProduct($categoryProductId)
    {
        $this->authLogin();
        $editCategoryProduct = DB::table('tbl_category_product')->where('category_id', $categoryProductId)->get();
        $managerCategoryProduct = view('admin.edit_category_product')->with('editCategoryProduct', $editCategoryProduct);
        return view('admin_layout')->with('admin.edit_category_product', $managerCategoryProduct);
    }

    public function updateCategoryProduct(Request $request, $categoryProductId)
    {
        $this->authLogin();
        $data = [
            'category_name' => $request->category_product_name,
            'category_desc' => $request->category_product_desc,
            'category_status' => $request->category_product_status
        ];

        DB::table('tbl_category_product')->where('category_id', $categoryProductId)->update($data);
        Session::put('message', 'Update product successfully!!!');
        return Redirect::to('all-category-product');
    }

    public function deleteCategoryProduct($categoryProductId)
    {
        $this->authLogin();
        DB::table('tbl_category_product')->where('category_id', $categoryProductId)->delete();
        Session::put('message', 'Delete product category successfully!!!');
        return Redirect::to('all-category-product');
    }

    // End function admin page

    public function showCategoryHome($categoryId)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();
        $category_by_id = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('tbl_product.category_id', $categoryId)->get();
        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id', $categoryId)->first();


        return view('pages.category.show_category')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('category_by_id', $category_by_id)->with('category_name', $category_name);
    }

}

