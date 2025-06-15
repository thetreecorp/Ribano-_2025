<?php
    return [
        'options' => [
            'balance_url' => env('NEAR_API_URL') . 'ft_balance_of',
            'storage_deposit_url' => env('NEAR_API_URL') . 'storage_deposit',
            'ft_transfer_url' => env('NEAR_API_URL') . 'ft_transfer',
            'mint_url' => env('NEAR_API_URL') . 'mint',
            'create_sub_account_url' => env('NEAR_API_URL') . 'create_sub_account',
            'create_normal_sub_account' => env('NEAR_API_URL') . 'create_normal_sub_account', // for normal user
            'deploy_url' => env('NEAR_API_URL') . 'deploy',
            
            "master_account_id" => "ribano.near",
            "private_key" => "ed25519:29GLb9FrtkHsZvXrgdKjyx3BWe7gqCBwTSDcQRfCcxCfrzdrTBMJfYtkLuQhWM8xgfjzSkBA2FF5mUNXuo7Br7JR",
            'paymoney_client_id' => env('PAYMONEY_CLIENTID'),
            'paymoney_client_secret' => env('PAYMONEY_CLIENTSECRET'),
            'success_url' => env('SUCCESS_URL'),
            'cancel_url' => env('CANCEL_URL'),
            
            'check_mobile' => env('CHECKMOBI_SECRET_KEY'),
            
            'master_account' => env('MASTER_ACCOUNT'),
            
            'xeedwallet_user_api' => env('XWALLET_URL') . 'create-user',
            
            'xeedwallet_currency_api' => env('XWALLET_URL') . 'submit-create-currency',
            
            'cache_time' => 86400,
            'cache_minutes' => 1440, // 24 hours
            
            'exchange_rates' => array(
                'USD' => 1,
                'AUD' => 0.6935,
                'BRL' => 0.1832,
                'CAD' => 0.7742,
                'CZK' => 0.0413,
                'DKK' => 0.1543,
                'EUR' => 1.2776,
                'HKD' => 0.1285,
                'HUF' => 0.0034,
                'ILS' => 0.2921,
                'JPY' => 0.0092,
                'MYR' => 0.2439,
                'MXN' => 0.0513,
                'NOK' => 0.1141,
                'NZD' => 0.6542,
                'PHP' => 0.0213,
                'PLN' => 0.2632,
                'GBP' => 1.2906,
                'RUB' => 0.0163,
                'SGD' => 0.7341,
                'SEK' => 0.1149,
                'CHF' => 1.0821,
                'THB' => 0.0335,
                'BDT' => 0.0134,
                'Rupee' => 0.0143
            )
        ]
    ];