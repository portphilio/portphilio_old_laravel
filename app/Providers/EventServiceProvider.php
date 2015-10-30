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

            // get the user created by the registration process
            $new_user = $link->getUser();

            // try to find a match using the extended properties passed
            $data = $provider->getUserDetails($token);
            $data = array_filter(get_object_vars($data));
            Debugbar::info($data);
            $old_user = User::findMatch((array) $data);

            // now compare them
            if (false !== $old_user && is_object($old_user)) {
                if ($old_user->id !== $new_user->id) {
                    // we found a match that they didn't
                    $link->setUser($old_user);
                    $new_user->delete();
                }
            }
        });

        Social::existing(function (LinkInterface $link, $provider, $token, $slug) {
            // handle linking an OAuth provider to a pre-existing user
            // Need to handle inappropriate linking, i.e. if the "existing" user was really someone else
        });

        Social::linking(function (LinkInterface $link, $provider, $token, $slug) {
            // fires after either registered or existing (i.e. in all cases)
            Debugbar::info($provider->getUserDetails($token));

            return redirect('/dashboard')->with('success', 'Welcome to Portphilio!');
        });
    }
}
