<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');


Auth::routes(['verify' => true]);




Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    // Inventories
    Route::resource('products', 'ProductController');
    Route::get('products/{product}/stock', 'ProductController@stock')->name('products.get_stock');
    Route::post('stock/{product}', 'ProductController@update_stock')->name('products.update_stock');

    Route::post('products/update/{product}', 'ProductController@updateproduct')->name('products.updateproduct');

    Route::get('products/product/detail', 'ProductController@detail_product')->name('products.detail_product');
    Route::get('products/product/detail/{code}', 'ProductController@scan_product')->name('products.scan_product');


    // Orders
    Route::get('orders', 'OrderController@orders')->name('orders');

    // Change Status
    Route::put('orders/status/{order}', 'OrderController@status')->name('orders.status');

    // receipt
    Route::get('orders/receipt/{order}', 'OrderController@receipt')->name('orders.receipt');

    // receipt
    Route::get('orders/receipt/{order}', 'OrderController@receipt')->name('orders.receipt');

    // Sales Reports
    Route::get('sales_reports/{filter}/{from}/{to}', 'OrderController@sales_reports')->name('sales_reports');
    // chart_reports
    Route::get('chart_reports/{filter_date}', 'OrderController@chart_reports')->name('chart_reports');


     // Admin List
     Route::get('staff_list', 'CustomerListController@staff_index')->name('staff');
     Route::post('staff_list', 'CustomerListController@staff_store')->name('staff.store');
     Route::put('staff_list/{staff}', 'CustomerListController@staff_update')->name('staff.update');



     // Categories
     Route::resource('categories', 'CategoryController');


     // activities
     Route::resource('activities', 'ActivityController');

     Route::resource('roles', 'RolesController');
     Route::resource('accounts', 'AccountController');
});
