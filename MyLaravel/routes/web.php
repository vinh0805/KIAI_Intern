<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Frontend
Route::get('/', 'HomeController@index');
Route::get('/trang-chu', 'HomeController@index');
Route::post('/search', 'HomeController@search');

// Admin
// Backend
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@showDashboard');
Route::get('/logout', 'AdminController@logout');
Route::post('/admin-dashboard', 'AdminController@dashboard');

// Category product
Route::get('/add-category-product', 'CategoryProduct@addCategoryProduct');
Route::get('/edit-category-product/{categoryProductId}', 'CategoryProduct@editCategoryProduct');
Route::get('/delete-category-product/{categoryProductId}', 'CategoryProduct@deleteCategoryProduct');
Route::get('/all-category-product', 'CategoryProduct@allCategoryProduct');

Route::get('/active-category-product/{categoryProductId}', 'CategoryProduct@activeCategoryProduct');
Route::get('/unactive-category-product/{categoryProductId}', 'CategoryProduct@unactiveCategoryProduct');

Route::post('/save-category-product', 'CategoryProduct@saveCategoryProduct');
Route::post('/update-category-product/{categoryProductId}', 'CategoryProduct@updateCategoryProduct');

// Brand product
Route::get('/add-brand-product', 'BrandProduct@addBrandProduct');
Route::get('/edit-brand-product/{brandProductId}', 'BrandProduct@editBrandProduct');
Route::get('/delete-brand-product/{brandProductId}', 'BrandProduct@deleteBrandProduct');
Route::get('/all-brand-product', 'BrandProduct@allBrandProduct');

Route::get('/active-brand-product/{brandProductId}', 'BrandProduct@activeBrandProduct');
Route::get('/unactive-brand-product/{brandProductId}', 'BrandProduct@unactiveBrandProduct');

Route::post('/save-brand-product', 'BrandProduct@saveBrandProduct');
Route::post('/update-brand-product/{brandProductId}', 'BrandProduct@updateBrandProduct');

// Product
Route::get('/add-product', 'ProductController@addProduct');
Route::get('/edit-product/{productId}', 'ProductController@editProduct');
Route::get('/delete-product/{productId}', 'ProductController@deleteProduct');
Route::get('/all-product', 'ProductController@allProduct');

Route::get('/active-product/{productId}', 'ProductController@activeProduct');
Route::get('/unactive-product/{productId}', 'ProductController@unactiveProduct');

Route::post('/save-product', 'ProductController@saveProduct');
Route::post('/update-product/{productId}', 'ProductController@updateProduct');

// Home page
// Category home page:
Route::get('/category/{categoryId}', 'CategoryProduct@showCategoryHome');
// Brand home page:
Route::get('/brand/{categoryId}', 'BrandProduct@showBrandHome');
// Product detail:
Route::get('/product-detail/{productId}', 'ProductController@detailProduct');

// Cart
Route::post('/save-cart', 'CartController@saveCart');
Route::post('/update-cart-quantity', 'CartController@updateCartQuantity');
Route::get('/show-cart', 'CartController@showCart');
Route::get('/delete-to-cart/{rowId}', 'CartController@deleteToCart');

// Checkout
Route::get('/login-checkout', 'CheckoutController@loginCheckout');
Route::get('/logout-checkout', 'CheckoutController@logoutCheckout');
Route::post('/add-customer', 'CheckoutController@addCustomer');
Route::post('/order-place', 'CheckoutController@orderPlace');
Route::post('/login-customer', 'CheckoutController@loginCustomer');
Route::get('/checkout', 'CheckoutController@showCheckout');
Route::get('/payment', 'CheckoutController@payment');
Route::post('/save-checkout-customer', 'CheckoutController@saveCheckoutCustomer');

// Order
Route::get('/manage-order', 'CheckoutController@manageOrder');
Route::get('/view-order/{orderId}', 'CheckoutController@viewOrder');
