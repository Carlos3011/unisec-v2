<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WebPay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con WebPay Plus
    |
    */

    'aes_key' => env('WEBPAY_AES_KEY', ''), // Clave AES en formato hexadecimal
    
    'environment' => env('WEBPAY_ENVIRONMENT', 'sandbox'), // 'sandbox' o 'production'
    
    'merchant_id' => env('WEBPAY_MERCHANT_ID', ''),
    
    'terminal_id' => env('WEBPAY_TERMINAL_ID', ''),
    
    // URLs de retorno
    'return_url' => env('WEBPAY_RETURN_URL', '/webpay/result'),
    
    'notify_url' => env('WEBPAY_NOTIFY_URL', '/webpay/notify'),
];