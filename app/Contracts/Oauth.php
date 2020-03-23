<?php

namespace App\Contracts;

interface Oauth{

    public static function generateOauthUri();

    public static function getAuthToken( $authCode );

    public static function getUser( $token );
}
