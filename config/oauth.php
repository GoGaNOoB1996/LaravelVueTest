<?php

return [
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID', '669998925731-ovkkcs25ieird34hmn6u8cm7pkeo6dg5.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'Yaf9y-FTdEJ-0cr1n1kd3tc6'),
        'redirect_uri'  => 'http://127.0.0.1:8000/callback/google'
    ],
    'facebook' => [
        'client_id'     => env('FB_CLIENT_ID', '2312778125691029'),
        'client_secret' => env('FB_CLIENT_SECRET', '8514df306e472f10b6a5215d586f38ff'),
        'redirect_uri'  => 'https://free.example.test/callback/facebook',
    ],
    'wordpress' => [
        'client_id'     => env('WP_CLIENT_ID', '68355'),
        'client_secret' => env('WP_CLIENT_SECRET', '5uPHEASjODCUX37eZbsa0TJFm5Ntt1XDz89QlGyPqNegfS58CkDMNNt0Yc3aTaj2'),
        'redirect_uri'  => env('WP_URL', 'http://127.0.0.1:8000/callback/wordpress'),
    ],
];
