<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Etsy\V1\Controllers',
        'prefix' => 'receipts',
    ], function ($api) {
        $api->get('pull', 'ReceiptsController@pull');
    });
    $api->group([
        'namespace' => 'Api\Etsy\V1\Controllers',
        'prefix' => 'tackings',
    ], function ($api) {
        $api->post('create', 'TrackingsController@create');
    });
});
