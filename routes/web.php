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

    // buckup
    Route::post('backup', 'OrderController@backup')->name('orders.backup');
    Route::get('download_backup', 'OrderController@download_backup')->name('orders.download_backup');



    // chart_reports
    Route::get('chart_reports/{filter_date}', 'OrderController@chart_reports')->name('chart_reports');
    Route::get('salesforcast/{category}/{m}/{y}', 'OrderController@chart_category')->name('chart_category');
    Route::get('forcasts', 'OrderController@forcast')->name('forcast');
    Route::get('forcasts/bar_charts_value/{year}', 'BarChartValueController@index')->name('line_charts_value.index');



     // Admin List
     Route::get('staff_list', 'CustomerListController@staff_index')->name('staff');
     Route::post('staff_list', 'CustomerListController@staff_store')->name('staff.store');
     Route::put('staff_list/{staff}', 'CustomerListController@staff_update')->name('staff.update');



     // Categories
     Route::resource('categories', 'CategoryController');


     // activities
     Route::resource('activities', 'ActivityController');

     // forcast
     Route::resource('forcast', 'ForcastController');

     Route::resource('roles', 'RolesController');
     Route::resource('accounts', 'AccountController');

     // purchase_order
     Route::get('purchase_order', 'PurchaseOrderController@index')->name('purchase_order.index');
     Route::post('purchase_order/order', 'PurchaseOrderController@order')->name('purchase_order.order');
     Route::get('purchase_order/delete/{id}', 'PurchaseOrderController@delete_order')->name('purchase_order.delete');
     Route::get('purchase_order/confirm', 'PurchaseOrderController@confirm_order')->name('purchase_order.confirm');
     Route::get('purchase_order/orders', 'PurchaseOrderController@orders')->name('purchase_order.orders');
     Route::get('purchase_order/receipt/{id}', 'PurchaseOrderController@receipt_order')->name('purchase_order.receipt');
     Route::get('purchase_order/verify/{id}', 'PurchaseOrderController@verify_order')->name('purchase_order.verify');
     Route::post('purchase_order/verify', 'PurchaseOrderController@verify')->name('purchase_order.verify');
     Route::get('purchase_order/recieve/{id}', 'PurchaseOrderController@recieve_order')->name('purchase_order.recieve');

     Route::get('purchase_order/deliveries', 'PurchaseOrderController@deliveries')->name('purchase_order.deliveries');

     // inventory reports
     Route::get('inventory_reports/{date}', 'InventoryReportsController@index')->name('inventory_reports.index');



});
