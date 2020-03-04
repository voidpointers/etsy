<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Etsy\V1\Controllers',
    ], function ($api) {
        $api->get('receipts/pull', 'ReceiptsController@pull');
        $api->get('listings/{shop_id}', 'ListingsController@index');
        $api->get('shop/{shop_id}', 'ShopsController@index');
        $api->post('shop/{shop_id}', 'ShopsController@update');
        $api->post('trackings/create', 'TrackingsController@create');
        $api->get('category', 'CategoriesController@index');
    });
    $api->group([
        'namespace' => 'Api\Etsy\V1\Controllers',
    ], function ($api) {
        $api->get('auth/redirect', 'AuthController@redirect');
        $api->get('auth/approve', 'AuthController@approve');
    });
});
