<?php

/**
 * Part of the Sentinel Social package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    2.0.3
 *
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 *
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | Connections are simple. Each key is a unique slug for the connection. Use
    | anything, just make it unique. This is how you reference it in Sentinel
    | Social. Each slug requires a driver, which must match a valid inbuilt
    | driver or may match your own custom class name that inherits from a
    | valid base driver.
    |
    | Make sure each connection contains an "identifier" and a "secret". These
    | are also known as "key" and "secret", "app id" and "app secret"
    | depending on the service. We're using "identifier" and
    | "secret" for consistency.
    |
    | OAuth2 providers may contain an optional "scopes" array, which is a
    | list of scopes you're requesting from the user for that connection.
    |
    | You may use multiple connections with the same driver!
    |
    */

    'connections' => [

        'facebook' => [
            'driver' => 'Facebook',
            'identifier' => env('FACEBOOK_ID'),
            'secret' => env('FACEBOOK_SECRET'),
            'scopes' => [
                'email',
            ],
            'icon' => 'facebook-square',
        ],

        'github' => [
            'driver' => 'GitHub',
            'identifier' => env('GITHUB_ID'),
            'secret' => env('GITHUB_SECRET'),
            'scopes' => [
                'user:email',
            ],
            'icon' => 'github-square',
        ],

        'google' => [
            'driver' => 'Google',
            'identifier' => env('GOOGLE_ID'),
            'secret' => env('GOOGLE_SECRET'),
            'scopes' => [
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/drive.readonly',
                'https://www.googleapis.com/auth/youtube',
            ],
            'icon' => 'google-plus-square',
        ],

        'instagram' => [
            'driver' => 'Instagram',
            'identifier' => env('INSTAGRAM_ID'),
            'secret' => env('INSTAGRAM_SECRET'),
            'scopes' => [
                'basic',
            ],
            'icon' => 'instagram',
        ],

        'linkedin' => [
            'driver' => 'LinkedIn',
            'identifier' => env('LINKEDIN_ID'),
            'secret' => env('LINKEDIN_SECRET'),
            'scopes' => [
                'r_basicprofile',
                'r_emailaddress',
            ],
            'icon' => 'linkedin-square',
        ],

        'microsoft' => [
            'driver' => 'Microsoft',
            'identifier' => env('MICROSOFT_ID'),
            'secret' => env('MICROSOFT_SECRET'),
            'scopes' => [
                'wl.basic',
                'wl.emails',
            ],
            'icon' => 'windows',
        ],

        'twitter' => [
            'driver' => 'Twitter',
            'identifier' => env('TWITTER_ID'),
            'secret' => env('TWITTER_SECRET'),
            'icon' => 'twitter-square',
        ],

        'tumblr' => [
            'driver' => 'Tumblr',
            'identifier' => env('TUMBLR_ID'),
            'secret' => env('TUMBLR_SECRET'),
            'icon' => 'tumblr-square',
        ],

        'vkontakte' => [
            'driver' => 'Vkontakte',
            'identifier' => env('VKONTAKTE_ID'),
            'secret' => env('VKONTAKTE_SECRET'),
            'scopes' => [],
            'icon' => 'vk',
       ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Link Model
    |--------------------------------------------------------------------------
    |
    | When users are registered, a "link repository" will map the social
    | authentications with user instances. Feel free to use your own model
    | with our provider.
    |
    */

    'link' => 'Cartalyst\Sentinel\Addons\Social\Models\Link',

];
