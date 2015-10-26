<?php

namespace Portphilio\Http\Controllers;

use Social;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Addons\Social\Models\LinkInterface;
use Cartalyst\Sentinel\Addons\Social\AccessMissingException;

class OauthController extends Controller
{
    /**
     * Authenticate a user from a 3rd party app.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthorizeGithub()
    {
        return redirect(Social::getAuthorizationUrl('github', url('oauth/github')));
    }

    /**
     * Authenticate a user from a 3rd party app.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGithub(Request $request)
    {
        $cb = $request->url();
        try {
            $user = Social::authenticate('github', $cb, function (LinkInterface $link, $provider, $token, $slug) {
                    // create a User instance
                    $user = $link->getUser();

                    // get user data from Github
                    $data = $provider->getUserDetails($token);
                    echo '<pre>';
                    print_r($user->toArray());
                    print_r($data);
                    echo '</pre>';
                    exit;
                    // use github data to populate user instance
                    $user->username = $data->nickname;
                    $user->first_name = $data->first_name;

                    $user->save();
                }
            );
        } catch (AccessMissingException $e) {
            if ($error = $request->input('error_message')) {
                return redirect('/login')->with('error', $error);
            }
            abort(404);
        }

        return redirect('/dashboard')->with('success', 'Welcome to Portphilio!');
    }

    /**
     * Authenticate a user from a 3rd party app.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthorizeFacebook()
    {
        return redirect(Social::getAuthorizationUrl('facebook', url('oauth/facebook')));
    }

    /**
     * Authenticate a user from a 3rd party app.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFacebook(Request $request)
    {
        $cb = $request->url();
        try {
            $user = Social::authenticate('facebook', $cb, function (LinkInterface $link, $provider, $token, $slug) {
                    // create a User instance
                    $user = $link->getUser();

                    // get user data from Facebook
                    $data = $provider->getUserDetails($token);
                    echo '<pre>';
                    print_r($user->toArray());
                    print_r($data);
                    echo '</pre>';
                    exit;
                    // use github data to populate user instance
                    $user->username = $data->nickname;
                    $user->first_name = $data->first_name;

                    $user->save();
                }
            );
        } catch (AccessMissingException $e) {
            if ($error = $request->input('error_message')) {
                return redirect('/login')->with('error', $error);
            }
            abort(404);
        }

        return redirect('/dashboard')->with('success', 'Welcome to Portphilio!');
    }
}
