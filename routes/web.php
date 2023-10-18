<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');


Auth::routes(['verify' => true]);




Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    // Inventories
    Route::resource('products', 'ProductController');
    Route::post('products/update/{product}', 'ProductController@updateproduct')->name('products.updateproduct');
    Route::post('products/stock/{product}', 'ProductController@addedstock')->name('products.addedproduct');
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

     // CustomerList
     Route::get('customer_list', 'CustomerListController@index')->name('customer');
     Route::get('customer_list/{user}/edit', 'CustomerListController@edit')->name('customer.edit');
     Route::get('customer_list/{user}/status', 'CustomerListController@status')->name('customer.status');

     Route::put('customer_list/{user}', 'CustomerListController@update')->name('customer.update');
     Route::put('customer_list/{user}/dpass', 'CustomerListController@defaultPassowrd')->name('customer.dpass');

     // Admin List
     Route::get('staff_list', 'CustomerListController@staff_index')->name('staff');
     Route::post('staff_list', 'CustomerListController@staff_store')->name('staff.store');
     Route::put('staff_list/{staff}', 'CustomerListController@staff_update')->name('staff.update');

     // Change Status
     Route::put('customer/status/{user}', 'CustomerListController@status')->name('customer.status12');

     // Categories
     Route::resource('categories', 'CategoryController');

     // activities
     Route::resource('activities', 'ActivityController');


    Route::get('styles', 'LayoutStyleController@index')->name('styles.index');
    Route::post('styles', 'LayoutStyleController@update')->name('styles.update');

});
