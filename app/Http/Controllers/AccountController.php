<?php

namespace Portphilio\Http\Controllers;

use Mail;
use Sentinel;
use Reminder;
use Activation;
use Portphilio\Http\Requests\LoginRequest;
use Portphilio\Http\Requests\ResetRequest;
use Portphilio\Http\Requests\NewPasswordRequest;
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
            }
        );

        return redirect('/login');
    }

    public function getLogin()
    {
        return view('accounts.login');
    }

    public function postLogin(LoginRequest $request)
    {
        try {
            if ($user = Sentinel::authenticate($request->except(['submit', '_token']), $request->input('remember'))) {
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

    public function getActivate($user_id, $activation_code)
    {
        if ($user = Sentinel::findById($user_id)) {
            if ($act = Activation::exists($user) ?: Activation::completed($user)) {
                if (!$act->completed) {
                    if (Activation::complete($user, $activation_code)) {
                        // success!
                        return redirect('/login')->with('success', 'Thank you! Your Portphilio account is now active. Please login.');
                    } else {
                        // activation failed. probably wrong activation code
                        return redirect('/register')->with('error', 'Ruh-roh! You may have used an invalid activation code. Please double check the link from your activation email and try again. If that doesn\'t work, please <a href="/reset">reset your activation code</a>.');
                    }
                } else {
                    // activation was already complete
                    return redirect('/login')->with('info', 'Your account was already activated.');
                }
            } else {
                // no activation exists; expired --> resend
                return redirect('/login')->with('warning', 'This activation code expired. Please <a href="/reset">reset it</a>.');
            }
        } else {
            // no user account with that id
            return redirect('/register')->with('warning', 'Sorry! We couldn\'t find an account with that ID. Please re-register below, or <a href="/contact">let us know about your problem</a>.');
        }
    }

    public function getReset($user_id = null, $reset_code = null)
    {
        if (empty($user_id) && empty($reset_code)) {
            return view('accounts.reset');
        } else {
            if ($user = Sentinel::findById($user_id)) {
                if ($reset = Reminder::exists($user, $reset_code)) {
                    return view('accounts.new_password', ['user' => $user, 'reset' => $reset]);
                } else {
                    return redirect('/reset')->with('error', 'Ruh-roh! You may have used an invalid reset code. Please double check the link from your reset email and try again.');
                }
            } else {
                // $user_id not found
                return redirect('/reset')->with('error', 'Sorry! We couldn\'t find an account with that ID.');
            }
        }
    }

    public function postReset(ResetRequest $request)
    {
        if ($user = Sentinel::findByCredentials(['login' => $request->input('login')])) {
            Mail::send(
                'accounts.emails.reset',
                ['user' => $user, 'base_url' => config('app.url'), 'reset' => Reminder::create($user)],
                function ($m) use ($user) {
                    $m->to($user->email, $user->first_name.' '.$user->last_name)
                      ->subject('Portphilio password reset link');
                }
            );

            return redirect('/login');
        } else {
            // user not found
             return back()->with('warning', 'The username or email you entered was not found.');
        }
    }

    public function putReset(NewPasswordRequest $request)
    {
        if ($user = Sentinel::findById($request->input('user_id'))) {
            if (Reminder::complete($user, $request->input('reset_code'), $request->input('password'))) {
                return redirect('/login')->with('success', 'Your Portphilio password was successfully reset. Please login.');
            } else {
                // password reset failed
            }
        } else {
            // $user_id not found
            return redirect('/reset')->with('error', 'Sorry! We couldn\'t find an account with that ID.');
        }
    }

    public function getLogout()
    {
        Sentinel::logout();

        return redirect('/login');
    }
}
