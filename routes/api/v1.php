<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Etsy\V1\Controllers',
        'prefix' => 'etsys',
    ], function ($api) {
        $api->get('pull', 'ReceiptsController@pull');
        $api->group([
            'middleware' => 'api.auth'
        ], function ($api) {
            $api->get('info', 'UsersController@info');
        });
    });
});
