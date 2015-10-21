<?php

namespace Portphilio\Http\Controllers;

use Mail;
use Sentinel;
use Activation;
use Portphilio\Http\Requests\RegistrationRequest;

class AccountController extends Controller
{
    public function getRegister()
    {
        return view('accounts.register');
    }

    public function postRegister(RegistrationRequest $request)
    {
        $user = Sentinel::register($request->except(['submit', '_token', 'email_confirmation', 'password_confirmation']));
        Mail::send(
            'accounts.emails.welcome',
            ['user' => $user, 'base_url' => config('app.url'), 'act' => Activation::create($user)],
            function ($m) use ($user) {
                $m->to($user->email, $user->first_name.' '.$user->last_name)
                  ->subject('Welcome to Portphilio! Activate your account...');
            /*'accounts.emails.test', [], function ($m) use ($user) { $m->to($user->email)->subject('Hi');*/
        });

        return redirect('/');
    }

    public function getLogin()
    {
        return view('accounts.login');
    }

    public function postLogin(Request $request)
    {
        $creds = [
            'login' => $request->input('login'),
            'password' => $request->input('password'),
        ];
        try {
            if ($user = Sentinel::authenticate($creds, $request->input('remember'))) {
                // success
                return redirect()->intended('dashboard');
            } else {
                // failure
                return back()->withInput();
            }
        } catch (NotActivatedException $e) {
        } catch (ThrottlingException $e) {
        }
    }
}
