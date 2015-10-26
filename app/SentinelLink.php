<?php

namespace Portphilio;

use Cartalyst\Sentinel\Addons\Social\Models\Link;

class SentinelLink extends Link
{
    /**
     * The users model name.
     *
     * @var string
     */
    protected static $usersModel = 'Portphilio\User';
}
