<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/etsy', function () use ($router) {
    $args = array(
        'params' => array(
            'listing_id' => 756097009
        ),
        // A list of associations
        'associations' => array(
            // Could be a simple association, sending something like: ?includes=Images
            'Images',
            // Or a composed one with (all are optional as Etsy API says) "scope", "limit", "offset", "select" and sub-associations ("associations")
            // ?includes=ShippingInfo(currency_code, primary_cost):active:1:0/DestinationCountry(name,slug)
            // 'ShippingInfo' => array(
            //     'scope' => 'active',
            //     'limit' => 1,
            //     'offset' => 0,
            //     'select' => array('currency_code', 'primary_cost'),
            //     // The only issue here is that sub-associations couldn't be more than one, I guess.
            //     'associations' => array(
            //         'DestinationCountry' => array(
            //             'select' => array('name', 'slug')
            //         )
            //     )
            // )
        )
    );
    $result = Etsy::findAllListingActive($args);
    return $result;
});

