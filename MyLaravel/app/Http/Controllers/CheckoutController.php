<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use PhpParser\Node\Stmt\Return_;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function authLogin()
    {
        $admin_id = Session::get('admin_id');
        if (isset($admin_id)) {
            return redirect('dashboard');
        } else {
            return redirect('admin')->send();
        }
    }

    public function loginCheckout()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product);
    }

    public function addCustomer(Request $request)
    {
        $data = [
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_password' => md5($request->customer_password),
            'customer_phone' => $request->customer_phone
        ];

        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return \redirect('/checkout');
    }

    public function showCheckout()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product);
    }

    public function saveCheckoutCustomer(Request $request)
    {
        $data = [
            'shipping_name' => $request->shipping_name,
            'shipping_address' => $request->shipping_address,
            'shipping_phone' => $request->shipping_phone,
            'shipping_email' => $request->shipping_email,
            'shipping_note' => $request->shipping_note
        ];

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id', $shipping_id);

        return \redirect('/payment');
    }

    public function payment()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product);
    }

    public function logoutCheckout()
    {
        Session::flush();
        return \redirect('login-checkout');
    }

    public function loginCustomer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email', $email)
            ->where('customer_password', $password)->first();

        if (isset($result)) {
            Session::put('customer_id', $result->customer_id);
            return \redirect('checkout');
        } else {
            return \redirect('login-checkout');
        }
    }

    public function orderPlace(Request $request)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '=', 1)
            ->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '=', 1)
            ->orderBy('brand_id', 'desc')->get();

        // insert payment
        $payment_data = [
            'payment_method' => $request->payment_option,
            'payment_status' => 'Waiting'
        ];
        $payment_id = DB::table('tbl_payment')->insertGetId($payment_data);

        // insert order
        $order_data = [
            'customer_id' => Session::get('customer_id'),
            'shipping_id' => Session::get('shipping_id'),
            'payment_id' => $payment_id,
            'order_total' => Cart::total(),
            'order_status' => 'Waiting'
        ];
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        // insert order details
        foreach (Cart::content() as $v_content) {
            $order_details_data = [
                'order_id' => $order_id,
                'product_id' => $v_content->id,
                'product_name' => $v_content->name,
                'product_price' => $v_content->price,
                'product_sale_quantity' => $v_content->qty
            ];
            DB::table('tbl_order_detail')->insert($order_details_data);
        }

        if ($payment_data['payment_method'] == 1) {
            echo 'Pay by direct bank transfer';
        } elseif ($payment_data['payment_method'] == 2) {
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product);
        } else {
            echo 'Pay by ATM';
        }
    }

    public function manageOrder()
    {
        $this->authLogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->select('tbl_order.*', 'tbl_customer.customer_name')
            ->orderBy('tbl_order.order_id', 'desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.view_order', $manager_order);
    }

    public function viewOrder($orderId)
    {
        $this->authLogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_order_detail', 'tbl_order.order_id', '=', 'tbl_order_detail.order_id')
            ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_detail.*')
            ->where('tbl_order.order_id', '=', $orderId)->get();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }

}

