<?php

namespace Portphilio;

use Gravatar;
use Cartalyst\Sentinel\Users\EloquentUser;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class User extends EloquentUser implements SluggableInterface
{
    use SluggableTrait;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Array of login column names.
     *
     * @var array
     */
    protected $loginNames = ['email', 'username'];

    /**
     * Array of fillable columns.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    /**
     * How to generate the user slug.
     *
     * @var array
     */
    protected $sluggable = ['build_from' => 'username', 'save_to' => 'username'];

    public function getAvatarAttribute()
    {
        return Gravatar::src($this->email);
    }

    /**
     * Gets the user's display name.
     *
     * @return string Created by concatenating the first and last names.
     */
    public function getDisplayNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Gets the slug used for generating URLs.
     *
     * @return string The same as the username.
     */
    public function getSlugAttribute()
    {
        return $this->username;
    }

    /**
     * Gets links to OAuth providers, e.g. Facebook.
     *
     * @return Portphilio\SentinelLink OAuth information for a 3rd party account.
     */
    public function links()
    {
        return $this->hasMany('Portphilio\SentinelLink');
    }
}
