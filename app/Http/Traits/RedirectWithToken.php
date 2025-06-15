<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @author: Ihteshamul Alam
 * @date: 2025-05-15
 * @description: This trait is used to generate a JWT token for the currently logged in user and redirect them to an external URL with the token as a query parameter.
 */

trait RedirectWithToken
{
    /**
     * Generate token and redirect user to external URL
     * 
     * @param string $redirectUri Base64 encoded redirect URL
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWithToken($redirectUri)
    {
        if (empty($redirectUri)) {
            return false;
        }
        
        // Generate token for currently logged in user
        $user = Auth::user();
        $customParameter = array();
        $customParameter['role'] = $user->roles->pluck('name')[0] ?? '';
        $customParameter['phone'] = $user->phone;
        $customParameter['email'] = $user->email;
        $customParameter['photo'] = $user->image;
        $customParameter['first_name'] = $user->firstname;
        $customParameter['last_name'] = $user->lastname;
        $customParameter['full_name'] = $customParameter['first_name'] . ' ' . $customParameter['last_name'];
        $customParameter['id'] = $user->id;
        
        // Generate JWT token
        // $token = JWTAuth::fromUser($user, $customParameter);
        $token = JWTAuth::claims($customParameter)->fromUser($user);
        
        if (function_exists('encryptToken')) {
            $customParameter['encryptToken'] = 1;
            $token = encryptToken($token);
        }

        // Decode redirect URL and redirect with token
        $decodedRedirectUri = base64_decode($redirectUri);
        
        if (filter_var($decodedRedirectUri, FILTER_VALIDATE_URL)) {
            $redirectUriWithToken = $decodedRedirectUri . 
                (parse_url($decodedRedirectUri, PHP_URL_QUERY) ? '&' : '?') . 
                'token=' . urlencode($token);
            
            return redirect($redirectUriWithToken);
        }
        
        return false;
    }
}