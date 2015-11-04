<?php

namespace Portphilio\Http\Controllers;

use Social;
use Illuminate\Http\Request;
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
            // NOTE: events handled in Portphilio\Providers\EventSerivceProvider
            $user = Social::authenticate('github', $cb);
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
    public function getAuthorize($slug)
    {
        return redirect(Social::getAuthorizationUrl($slug, url('oauth/authenticate/'.$slug)));
    }

    /**
     * Authenticate a user from a 3rd party app.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthenticate(Request $request, $slug)
    {
        $cb = $request->url();
        try {
            // NOTE: events handled in Portphilio\Providers\EventSerivceProvider
            $user = Social::authenticate($slug, $cb);
        } catch (AccessMissingException $e) {
            if ($error = $request->input('error_message')) {
                return redirect('/login')->with('error', $error);
            }
            abort(404);
        }

        return redirect('/users/'.$user->username)->with('success', 'Welcome to Portphilio!');
    }
}
