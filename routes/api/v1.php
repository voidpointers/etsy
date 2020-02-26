<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Etsy\V1\Controllers',
    ], function ($api) {
        $api->get('receipts/pull', 'ReceiptsController@pull');
        $api->get('listings/pull', 'ListingsController@pull');
        $api->post('trackings/create', 'TrackingsController@create');
    });
});
