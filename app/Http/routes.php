<?php
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::get('/', function () {
    return 'APIs';
});

Route::group(array(
    'prefix' => '/api'
), function () {

    // control user account
    Route::group(array(
        'prefix' => '/auth'
    ), function () {
        Route::post('/login', 'Api\AuthController@login');
        Route::post('/confirm-token', 'Api\AuthController@confirm');
        Route::post('/forgot', 'Api\AuthController@forgot');
        Route::post('/reset', 'Api\AuthController@reset');
        Route::post('/resend-verify', 'Api\AuthController@resendVerifyEmail');
        Route::delete('/remove-avatar', 'Api\AuthController@removeAvatar');
    });
    
    Route::group(array(
            'prefix' => '/categories'
        ), function () {
            Route::get('/', 'Api\CategoriesController@index');
            Route::get('/{id}', 'Api\CategoriesController@get');
            Route::get('/{id}/products', 'Api\CategoriesController@getProduct');
        });

// products
        Route::group(array(
            'prefix' => '/products'
        ), function () {

            Route::get('/', 'Api\ProductController@index');
            Route::get('/{id}', 'Api\ProductController@get');
            Route::post('/', 'Api\ProductController@create');
            Route::put('/{id}', 'Api\ProductController@update');
            Route::delete('/{id}', 'Api\ProductController@delete');

        });

    Route::get('/test', function () {
        echo \Illuminate\Support\Facades\Hash::make('Abc123456');
    });


    // control admin account
    Route::group(array(
        'prefix' => '/admin'
    ), function () {
        Route::post('/login', 'Api\AuthAdminController@login');
        Route::post('/forgot', 'Api\AuthAdminController@forgot');
        Route::post('/confirm-token', 'Api\AuthAdminController@confirm');
        Route::post('/reset', 'Api\AuthAdminController@reset');
    });

    // image
    Route::group(array(
        'prefix' => '/images'
    ), function () {
        Route::get('/game/{id}', 'Api\ImageController@getGameImage');
        Route::get('/game/{id}/thumbnail', 'Api\ImageController@getGameThumbnail');
        Route::get('/results/{hash}', 'Api\ImageController@getResultImage');
        Route::get('/results/{hash}/thumbnail', 'Api\ImageController@getResultThumbnail');
    });

    // collections
        Route::group(array(
            'prefix' => '/collections'
        ), function () {
            Route::get('/', 'Api\CollectionController@index');
            Route::get('/{id}', 'Api\CollectionController@get');
            Route::get('/{id}/products', 'Api\CollectionController@getProduct');
            Route::post('/', 'Api\CollectionController@create');
            Route::put('/{id}', 'Api\CollectionController@update');
            Route::delete('/{id}', 'Api\CollectionController@delete');
        });

        // catalogs
        Route::group(array(
            'prefix' => '/catalogs'
        ), function () {
            Route::get('/', 'Api\CatalogController@index');
            Route::get('/{id}', 'Api\CatalogController@get');
            Route::post('/', 'Api\CatalogController@create');
            Route::put('/{id}', 'Api\CatalogController@update');
            Route::delete('/{id}', 'Api\CatalogController@delete');
        });

        // news
        Route::group(array(
            'prefix' => '/news'
        ), function () {
            Route::get('/{id}', 'Api\NewsController@get');
            Route::post('/', 'Api\NewsController@create');
            Route::put('/{id}', 'Api\NewsController@update');
            Route::delete('/{id}', 'Api\NewsController@delete');
        });


    // apis require authenticated
    Route::group(array(
        'middleware' => array('api.authRequired')
    ), function () {

        Route::group(array(
            'prefix' => '/verify'
        ), function () {
            Route::post('/', 'Api\VerifyController@VerifyOTP');
            Route::post('/check', 'Api\VerifyController@checkVerifyOTP');
        });

        // administrator
        Route::group(array(
            'prefix' => '/admin'
        ), function () {
            Route::get('/', 'Api\UserController@index');
            Route::get('/me', 'Api\AuthAdminController@findMe');
            Route::put('/me', 'Api\AuthAdminController@updateMe');
            Route::post('/logout', 'Api\AuthAdminController@logout');
        });

        // registered user
        Route::group(array(
            'prefix' => '/auth'
        ), function () {
            Route::get('/me', 'Api\AuthController@findMe');
            Route::post('/change-password', 'Api\AuthController@changePassword');
            Route::post('/upload', 'Api\AuthController@uploadAvatar');
            Route::put('/me', 'Api\AuthController@updateMe');
            Route::put('/additional-info', 'Api\AuthController@updateAdditionalInfo');
            Route::post('/logout', 'Api\AuthController@logout');
        });

        Route::group(array(
            'prefix' => '/roles'
        ), function () {
            Route::get('/', 'Api\RoleController@index');
        });

        // user account api
        Route::group(array(
            'prefix' => '/users'
        ), function () {
            Route::get('/', 'Api\UserController@index');
            Route::get('/{id}', 'Api\UserController@get');
            Route::get('/{id}/overview', 'Api\UserController@getOverview');
            Route::get('/{id}/opponents', 'Api\UserController@getOpponents');
            Route::get('/{id}/feedback', 'Api\UserController@getFeedback');
            Route::post('/{id}/reset-password', 'Api\UserController@resetPassword');
            Route::post('/{id}/send-email', 'Api\UserController@sendEmail');
            Route::post('/{id}/upload', 'Api\UserController@uploadAvatar');
            Route::put('/{id}', 'Api\UserController@update');
            Route::delete('/{id}', 'Api\UserController@delete');
        });

//        // categories
//        Route::group(array(
//            'prefix' => '/categories'
//        ), function () {
//            Route::get('/', 'Api\CategoriesController@index');
//            Route::get('/{id}', 'Api\CategoriesController@get');
//            Route::post('/{action}', 'Api\CategoriesController@create');
//            Route::put('/{id}', 'Api\CategoriesController@update');
//            Route::delete('/{id}', 'Api\CategoriesController@delete');
//
//        });

    });

    Route::group(array(
        'middleware' => ['api.authNotRequired']
    ), function () {
        //platforms
    
        //games
        Route::group(array(
            'prefix' => '/games'
        ), function () {
            Route::get('/', 'Api\GameController@index');
            Route::get('/{id}', 'Api\GameController@get');
            Route::post('/{id}/favourite', 'Api\GameController@favouriteTo');
        });

        // locations
        Route::group(array(
            'prefix' => '/locations'
        ), function () {
            Route::get('/', 'Api\LocationController@index');
        });

        // newsletter
        Route::group(array(
            'prefix' => '/newsletters'
        ), function () {
            Route::get('/', 'Api\NewsletterController@index');
        });
    });
});
