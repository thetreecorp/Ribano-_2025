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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 'facebook' => [
    //     'client_id'     => '926934705179875',
    //     'client_secret' => '50074952e6355aa4b27bff75c82e377c',
    //     'redirect'      => env('FACEBOOK_CALLBACK_URL'),
    // ],
	
	'linkedin-openid' => [
		'client_id'     => '779lvquw3yk3wo',
		'client_secret' => 'AgBNPvwvWrbnnVDo',
		'redirect'      => env('LINKEDIN_CALLBACK_URL'),
	],
	
// 	'twitter' => [
// 		'client_id'       => 'FeNHJ3lilUHR2rV9NPGGzFrdO',
// 		'client_secret'   => 'wkbH9ImOCVev0wVsaVz151ejdqeXmzcH8IrHP3Z4zcYNuqck7L',
// 		'redirect'        => env('TWITTER_CALLBACK_URL'),
// 	],
	
    'google' => [
        'client_id'     => '807391802298-qr1m2e91hqvhh6s6j2l43jnq10jethci.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => env('GOOGLE_CALLBACK_URL'),
    ],

];
