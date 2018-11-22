<?php
Route::get('/test', 'TestController@index')->name('test');
Route::get('login', ['as' => 'backend.login-form', 'uses' => 'Backend\UserController@loginForm']);
Route::post('login', ['as' => 'backend.check-login', 'uses' => 'Backend\UserController@checkLogin']);
Route::get('logout', ['as' => 'backend.logout', 'uses' => 'Backend\UserController@logout']);
Route::group(['namespace' => 'Backend', 'middleware' => 'isAdmin'], function()
{    
Route::get('/iform', ['as' => 'ix', 'uses' => "OrdersController@iform"]);   
    Route::get('/', ['as' => 'orders.index', 'uses' => "OrdersController@index"]);
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/create/', ['as' => 'orders.create', 'uses' => 'OrdersController@create']);        
        Route::post('/store', ['as' => 'orders.store', 'uses' => 'OrdersController@store']);
        Route::get('{id}/edit',   ['as' => 'orders.edit', 'uses' => 'OrdersController@edit']);
        Route::post('/update', ['as' => 'orders.update', 'uses' => 'OrdersController@update']);
        Route::post('/update-status', ['as' => 'orders.update-status', 'uses' => 'OrdersController@updateStatus']);
        Route::get('{id}/destroy', ['as' => 'orders.destroy', 'uses' => 'OrdersController@destroy']);
        
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', ['as' => 'customer.index', 'uses' => "CustomerController@index"]);
        Route::get('/create/', ['as' => 'customer.create', 'uses' => 'CustomerController@create']);        
        Route::post('/store', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);
        Route::get('{id}/edit',   ['as' => 'customer.edit', 'uses' => 'CustomerController@edit']);
        Route::post('/update', ['as' => 'customer.update', 'uses' => 'CustomerController@update']);
        Route::get('{id}/destroy', ['as' => 'customer.destroy', 'uses' => 'CustomerController@destroy']);
        Route::post('/update-status', ['as' => 'customer.update-status', 'uses' => 'CustomerController@updateStatus']);
        
    });

     Route::group(['prefix' => 'logs'], function () {
        Route::get('/', ['as' => 'logs.index', 'uses' => "LogsController@index"]);
    });

    Route::group(['prefix' => 'staff'], function () {
        Route::get('/', ['as' => 'staff.index', 'uses' => "StaffController@index"]);
        Route::get('/create/', ['as' => 'staff.create', 'uses' => 'StaffController@create']);        
        Route::post('/store', ['as' => 'staff.store', 'uses' => 'StaffController@store']);
        Route::get('{id}/edit',   ['as' => 'staff.edit', 'uses' => 'StaffController@edit']);
        Route::post('/update', ['as' => 'staff.update', 'uses' => 'StaffController@update']);
        Route::get('{id}/destroy', ['as' => 'staff.destroy', 'uses' => 'StaffController@destroy']);
        

    });
    Route::group(['prefix' => 'orders-detail'], function () {       
        Route::get('/{order_id}', ['as' => 'orders-detail.index', 'uses' => 'OrderDetailController@index']);
        Route::get('/{order_id}/create', ['as' => 'orders-detail.create', 'uses' => 'OrderDetailController@create']);
        Route::get('/{id}/edit', ['as' => 'orders-detail.edit', 'uses' => 'OrderDetailController@edit']);
        Route::post('/store', ['as' => 'orders-detail.store', 'uses' => 'OrderDetailController@store']);
        Route::post('/update', ['as' => 'orders-detail.update', 'uses' => 'OrderDetailController@update']);
        Route::get('{id}/destroy', ['as' => 'orders-detail.destroy', 'uses' => 'OrderDetailController@destroy']);
    });
    
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => "SettingsController@dashboard"]);
  
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
        Route::post('/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
        Route::get('/noti', ['as' => 'settings.noti', 'uses' => 'SettingsController@noti']);        
        Route::post('/storeNoti', ['as' => 'settings.store-noti', 'uses' => 'SettingsController@storeNoti']);
    });
    Route::group(['prefix' => 'report'], function () {
        Route::get('/', ['as' => 'report.index', 'uses' => 'ReportController@index']);     
        Route::post('/search-price-other-site', ['as' => 'crawler.search-price-other-site', 'uses' => 'CompareController@search']);
    });
    Route::group(['prefix' => 'district'], function () {
        Route::get('/', ['as' => 'district.index', 'uses' => 'DistrictController@index']);
        Route::get('/create', ['as' => 'district.create', 'uses' => 'DistrictController@create']);
        Route::post('/store', ['as' => 'district.store', 'uses' => 'DistrictController@store']);
        Route::get('{id}/edit',   ['as' => 'district.edit', 'uses' => 'DistrictController@edit']);
        Route::post('/update', ['as' => 'district.update', 'uses' => 'DistrictController@update']);
        Route::get('{id}/destroy', ['as' => 'district.destroy', 'uses' => 'DistrictController@destroy']);
    });
    Route::group(['prefix' => 'color'], function () {
        Route::get('/', ['as' => 'color.index', 'uses' => 'ColorController@index']);
        Route::get('/create', ['as' => 'color.create', 'uses' => 'ColorController@create']);
        Route::post('/store', ['as' => 'color.store', 'uses' => 'ColorController@store']);
        Route::get('{id}/edit',   ['as' => 'color.edit', 'uses' => 'ColorController@edit']);
        Route::post('/update', ['as' => 'color.update', 'uses' => 'ColorController@update']);
        Route::get('{id}/destroy', ['as' => 'color.destroy', 'uses' => 'ColorController@destroy']);
    });  
    Route::group(['prefix' => 'size'], function () {
        Route::get('/', ['as' => 'size.index', 'uses' => 'SizeController@index']);
        Route::get('/create', ['as' => 'size.create', 'uses' => 'SizeController@create']);
        Route::post('/store', ['as' => 'size.store', 'uses' => 'SizeController@store']);
        Route::get('{id}/edit',   ['as' => 'size.edit', 'uses' => 'SizeController@edit']);
        Route::post('/update', ['as' => 'size.update', 'uses' => 'SizeController@update']);
        Route::get('{id}/destroy', ['as' => 'size.destroy', 'uses' => 'SizeController@destroy']);
    });
    Route::post('/tmp-upload', ['as' => 'image.tmp-upload', 'uses' => 'UploadController@tmpUpload']);
    Route::post('/tmp-upload-multiple', ['as' => 'image.tmp-upload-multiple', 'uses' => 'UploadController@tmpUploadMultiple']);    
    Route::post('/change-value', ['as' => 'change-value', 'uses' => 'GeneralController@changeValue']);
    
    Route::post('/update-order', ['as' => 'update-order', 'uses' => 'GeneralController@updateOrder']);
    Route::post('/ck-upload', ['as' => 'ck-upload', 'uses' => 'UploadController@ckUpload']);
    Route::post('/get-slug', ['as' => 'get-slug', 'uses' => 'GeneralController@getSlug']);    

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', ['as' => 'account.index', 'uses' => 'AccountController@index']);
        Route::get('/change-password', ['as' => 'account.change-pass', 'uses' => 'AccountController@changePass']);
        Route::post('/store-password', ['as' => 'account.store-pass', 'uses' => 'AccountController@storeNewPass']);
        Route::get('/update-status/{status}/{id}', ['as' => 'account.update-status', 'uses' => 'AccountController@updateStatus']);
        Route::get('/create', ['as' => 'account.create', 'uses' => 'AccountController@create']);
        Route::post('/store', ['as' => 'account.store', 'uses' => 'AccountController@store']);
        Route::get('{id}/edit',   ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
        Route::post('/update', ['as' => 'account.update', 'uses' => 'AccountController@update']);
        Route::get('{id}/destroy', ['as' => 'account.destroy', 'uses' => 'AccountController@destroy']);
    });      
});