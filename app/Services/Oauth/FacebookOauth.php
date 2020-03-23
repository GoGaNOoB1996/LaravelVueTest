<?php

namespace App\Services\Oauth;

use GuzzleHttp\Client;
use App\Contracts\Oauth;
use Illuminate\Support\Str;

class FacebookOauth implements Oauth
{
    public static function generateOauthUri() {
        $params = array(
            'client_id'     => config('oauth.facebook.client_id'),
            'redirect_uri'  => config('oauth.facebook.redirect_uri'),
            'state'         => Str::random(40)
        );

        return 'https://www.facebook.com/v6.0/dialog/oauth' . '?' . http_build_query($params);
    }

    public static function getAuthToken($authCode) {
        $client = new Client();
        $response = $client->request('POST', 'https://graph.facebook.com/v6.0/oauth/access_token', [
            'form_params' => [
                'client_id'     => config('oauth.facebook.client_id'),
                'redirect_uri'  => config('oauth.facebook.redirect_uri'),
                'client_secret' => config('oauth.facebook.client_secret'),
                'code'          => $authCode,
            ]
        ]);

        $response = json_decode($response->getBody());
        return $response->access_token;
    }


    public static function getUser($token) {
        $client = new Client();
        $response = $client->request('GET', 'https://graph.facebook.com/v6.0/me?access_token=' . $token . '&fields=id,name,email');

        $response = json_decode($response->getBody());
        return $response;
    }
}
