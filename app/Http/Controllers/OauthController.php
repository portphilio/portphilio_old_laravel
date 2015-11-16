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
        session(['user' => $user]);

        return redirect('/users/profile')->with('success', 'Welcome to Portphilio!');
    }
}
