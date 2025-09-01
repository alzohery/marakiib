<?php

return [
    'merchant_code'   => env('TWOCHECKOUT_MERCHANT_CODE'),
    'private_key'     => env('TWOCHECKOUT_PRIVATE_KEY'),
    'publishable_key' => env('TWOCHECKOUT_PUBLISHABLE_KEY'),
    'secret_key'      => env('TWOCHECKOUT_SECRET_KEY'),
    'secret_word'     => env('TWOCHECKOUT_SECRET_WORD'),
    'env'             => env('TWOCHECKOUT_ENV', 'sandbox'),
];
