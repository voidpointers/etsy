<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Shop\Entities\Shop;

class AuthController extends Controller
{
    public function redirect()
    {
        return redirect(\Etsy::authorize(env('ETSY_REDIRECT_URI')));
    }

    public function approve(Request $request)
    {
        $credentials = \Etsy::approve($request->get('oauth_token'), $request->get('oauth_verifier'));

        return $this->user($credentials);
    }

    public function user(array $credentials)
    // public function user()
    {
        $user = \Etsy::getUserDetails();
        $shop = \Etsy::findAllUserShops([
            'params' => [
                'user_id' => $user->uid
            ]
        ]);
        // $credentials = [
        //     'access_secret' => 'd5cf360a96',
        //     'access_token' => '76fd62c2c980ecd90b4af0baaf8fee',
        // ];
        (new Shop)->store($shop['results'], $credentials);
        return $shop;
    }
}
