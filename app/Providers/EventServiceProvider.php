<?php

namespace Portphilio\Providers;

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
        Social::linking(function (LinkInterface $link, $provider, $token, $slug) {
            // handle new registration through OAuth provider
        });

        Social::registering(function (LinkInterface $link, $provider, $token, $slug) {
            // handle new registration through OAuth provider
        });

        Social::registered(function (LinkInterface $link, $provider, $token, $slug) {
            // handle new registration through OAuth provider
        });

        Social::existing(function (LinkInterface $link, $provider, $token, $slug) {
            // handle linking an OAuth provider to a pre-existing user
        });
    }
}
