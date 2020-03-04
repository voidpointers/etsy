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
        $credentials = \Etsy::approve(
            $request->get('oauth_token'),
            $request->get('oauth_verifier')
        );

        return [
            'access_token' => $credentials->getIdentifier(),
            'access_token_secret' => $credentials->getSecret(),
        ]; 
    }
}
