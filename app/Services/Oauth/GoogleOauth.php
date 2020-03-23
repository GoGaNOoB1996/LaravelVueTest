<?php

namespace App\Services\Oauth;

use GuzzleHttp\Client;
use App\Contracts\Oauth;
use Illuminate\Support\Str;

class GoogleOauth implements Oauth
{
    public static function generateOauthUri() {
        $params = array(
            'client_id'     => config('oauth.google.client_id'),
            'redirect_uri'  => config('oauth.google.redirect_uri'),
            'response_type' => 'code',
            'scope'         => 'openid profile email',
            'access_type'   => 'offline',
            'state'         => Str::random(40)
        );

        return 'https://accounts.google.com/o/oauth2/v2/auth' . '?' . http_build_query($params);
    }

    public static function getAuthToken($authCode) {
        $client = new Client();
        $response = $client->request('POST', 'https://www.googleapis.com/oauth2/v4/token', [
            'form_params' => [
                'client_secret' => config('oauth.google.client_secret'),
                'redirect_uri'  => config('oauth.google.redirect_uri'),
                'client_id'     => config('oauth.google.client_id'),
                'grant_type'    => 'authorization_code',
                'code'          => $authCode,
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response->access_token;
    }


    public static function getUser($token) {
        $client = new Client();

        $response = $client->request('GET', 'https://www.googleapis.com/oauth2/v3/userinfo', [
            'headers' => [
                'Authorization' => "Bearer ${token}"
            ]
        ]);

        $response = json_decode($response->getBody());
        return $response;
    }
}
