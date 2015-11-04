<?php

namespace Portphilio\Providers;

use Social;
use Debugbar;
use Portphilio\User;
use Cartalyst\Sentinel\Addons\Social\Models\LinkInterface;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Portphilio\Events\SomeEvent' => [
            'Portphilio\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        // Handle Sentinel Social events
        Social::registered(function (LinkInterface $link, $provider, $token, $slug) {
            // fires just after new user is registered through OAuth provider (Manager:337)
            // need to create and send a password reset, or redirect to password reset page
            // also should probably send email with credentials

            // try to find a match using the extended properties passed
            $ud = $provider->getUserDetails($token);
            Debugbar::info($ud);
            $data = [];
            foreach (['nickname', 'name', 'firstName', 'lastName'] as $prop) {
                if (!empty($ud->{$prop})) {
                    $data[$prop] = $ud->{$prop};
                }
            }
            $old_user = User::findMatch($data);
            Debugbar::info($old_user);

            // add missing fields to the link object
            $user->setSocialUrl($link, $ud);
            $user->setSocialUsername($link, $ud);

            // now compare them
            if (false !== $old_user && is_object($old_user)) {
                // get the user created by the registration process
                $new_user = $link->getUser();

                if ($old_user->id !== $new_user->id) {
                    // we found a match that they didn't
                    // TODO: confirm that they are the same accounts!!!
                    $link->setUser($old_user);
                    $new_user->delete();
                }
            }
        });

        Social::existing(function (LinkInterface $link, $provider, $token, $slug) {
            // handle linking an OAuth provider to a pre-existing user
            $data = $provider->getUserDetails($token);
            $user = $link->getUser();
            $user->setSocialUrl($link, $data);
            $user->setSocialUsername($link, $data);
        });

        Social::linking(function (LinkInterface $link, $provider, $token, $slug) {
            // fires after either registered or existing (i.e. in all cases)

            return redirect('/dashboard')->with('success', 'Welcome to Portphilio!');
        });
    }
}
