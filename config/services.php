<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    // 'myfatoorah' => [
    //     'url' => env('MYFATOORAH_URL', 'https://apitest.myfatoorah.com'),
    //     'token' => env(''),
    //     'currency' => env('MYFATOORAH_CURRENCY', 'EGP'), // أو العملة المناسبة
    // ],

    'myfatoorah' => [
        'url' => env('MYFATOORAH_URL', 'https://apitest.myfatoorah.com'), // sandbox أو production حسب حسابك
        'token' => env('MYFATOORAH_TOKEN', 'hbP8rPrey6zTvnCybMsK1bKH44xjhxH1tm085IFxEtyFb7NZa8GfbOMOHah7Crla5zMm0HQLnT46KIoCS4ye6rrZRiAJVNqOG0mY8Tabsktr9Z40dOalGUy_WsvDQm2FS0G_XzIpKXliXQCY5uyHCdK0zmLGOaZR2bKcvkmjAe8nlEllA8RWJkO67TpqKWmNfySKkfffnW6KfBEW_aDy44l4hVInX_QGnB8InJYlGp3XdGjvwngdkaSt0RCK_gCnaaQ3Qk0jb5LDa9Nu35umct4eyyUojXO3q2kfgwKWV6_zRN4Pp5ULEfSHCDYxyihVi0ukI46VRGbRlPhxaW6qXVH0ZvcxZWFBI5_SgzdOVgxlonYXwG1OmmBH3hgnuog5StyRzlgN08m9FTEJbSC57QcnewVmgzp5oKSN7w16TUoAKZhD3J54jRgOdoMC6j2-fnIvq_Aer3egokqTP8NUp9gYAHFSr5MgbR4wn5JbCL-YS5fTwxwjlELOFeCQT1qhGOYx0ItZe7mPV7IdH63Y-rx9ObxaiBZHUE15KqfEkanh0S7EV5ZzGkqQYF50IqW8YI4bmTaDxk4PE_W9dcplDqiIQSJG2wR5P3esctvqqnha6UBlyG32jVXoonfkP0kPbRRd2YhdAX_2cYjZop7MVUMWD5JlTgzs7sz0vLdtt13TcEj8_5r_owyx2x9CzRLi8hRmoQ'),
        'currency' => env('MYFATOORAH_CURRENCY', 'EGP'), // الجنيه المصري
    ],





];
