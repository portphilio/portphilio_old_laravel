<?php

namespace Portphilio\Providers;

use Social;
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
        });

        Social::existing(function (LinkInterface $link, $provider, $token, $slug) {
            // handle linking an OAuth provider to a pre-existing user
            // Need to handle inappropriate linking, i.e. if the "existing" user was really someone else
        });

        Social::linking(function (LinkInterface $link, $provider, $token, $slug) {
            // fires after either registered or existing (i.e. in all cases)
            return redirect('/dashboard')->with('success', 'Welcome to Portphilio!');
        });
    }
}
