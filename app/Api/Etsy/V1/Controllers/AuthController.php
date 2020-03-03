<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Shop\Entities\Shop;

class AuthController extends Controller
{
    public function redirect($provider)
    {
        return \Etsy::authorize(env('ETSY_REDIRECT_URI'));
    }

    public function approve(Request $request)
    {
        $credentials = \Etsy::approve(
            $request->get('oauth_token'),
            $request->get('oauth_verifier')
        );

        Shop::create([
            'auth_token' => $_GET['oauth_token'],
            'auth_secret' => $_COOKIE['request_secret'],
        ]);
    }
}
