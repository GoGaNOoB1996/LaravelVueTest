<?php


namespace App\Services\Oauth;

use GuzzleHttp\Client;
use App\Contracts\Oauth;
use Illuminate\Support\Str;

class WordpressOauth implements Oauth
{

    public static function generateOauthUri() {
        $params = array(
            'client_id'     => config('oauth.wordpress.client_id'),
            'redirect_uri'  => config('oauth.wordpress.redirect_uri'),
            'response_type' => 'code',
            'scope'         => 'auth',
            'state'         => Str::random(40)
        );

        return 'https://public-api.wordpress.com/oauth2/authenticate' . '?' . http_build_query($params);
    }

    public static function getAuthToken($authCode) {
        $client = new Client();
        $response = $client->request('POST', 'https://public-api.wordpress.com/oauth2/token', [
            'form_params' => [
                'client_secret' => config('oauth.wordpress.client_secret'),
                'redirect_uri'  => config('oauth.wordpress.redirect_uri'),
                'client_id'     => config('oauth.wordpress.client_id'),
                'grant_type'    => 'authorization_code',
                'code'          => $authCode,
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response->access_token;
    }

    public static function getUser($token) {
        $client = new Client();

        $response = $client->request('GET', 'https://public-api.wordpress.com/rest/v1/me/', [
            'headers' => [
                'Authorization' => "Bearer ${token}"
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response;
    }
}
