<?php

namespace Portphilio;

use Gravatar;
use Cartalyst\Sentinel\Users\EloquentUser;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cartalyst\Sentinel\Addons\Social\Models\LinkInterface;

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

    /**
     * Returns the URL to the avatar image, default size.
     *
     * @return string The URL to the avatar
     */
    public function getAvatarAttribute()
    {
        return Gravatar::src($this->email);
    }

    /**
     * Gets the URL to a larger version of the avatar image.
     *
     * @return string The URL to the image
     */
    public function getProfilePicAttribute()
    {
        return Gravatar::src($this->email, 238);
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

    /**
     * Returns the social network link associated with a particular provider
     * for this user.
     *
     * @param string $slug The name of the provider, e.g. facebook, google, etc.
     *
     * @return mixed Returns a Portphilio\SentinelLink on success, false on failure
     */
    public function getLinkByProvider($slug)
    {
        foreach ($this->links as $link) {
            if ($slug == $link->provider) {
                return $link;
            }
        }

        return false;
    }

    /**
     * Find a user that matches on nickname, first/last name, or full name.
     *
     * @param array $atts The array of search parameters
     *
     * @return mixed Returns User object on success, false on failure
     */
    public static function findMatch($atts)
    {
        // convert the $atts into individual variables
        extract($atts);
        // try to match on the various properties
        if (isset($nickname)) {
            if ($user = self::where('username', $nickname)->first()) {
                if (!empty($user)) {
                    return $user;
                }
            }
        }
        if (isset($firstName, $lastName)) {
            if ($user = self::where('first_name', $firstName)->where('last_name', $lastName)->first()) {
                if (!empty($user)) {
                    return $user;
                }
            }
        }
        if (isset($name)) {
            $users = self::all();
            foreach ($users as $u) {
                similar_text($u->display_name, $name, $pct);
                if ($pct >= 0.85) {
                    return $u;
                }
            }
        }

        return false;
    }

    public function setSocialUrl(LinkInterface $link, $data)
    {
        if (empty($link->url)) {
            switch ($link->provider) {
                case 'facebook': $link->url = $data->urls['Facebook']; break;
                case 'google': $link->url = 'https://plus.google.com/'.$data->uid; break;
                case 'github': $link->url = 'https://github.com/'.$data->uid; break;
                case 'linkedin':
                case 'microsoft': $link->url = $data->urls; break;
                case 'twitter':
                case 'instagram': $link->url = 'https://'.$link->provider.'.com/'.$data->nickname; break;
            }
            $link->save();
        }
    }

    public function setSocialUsername(LinkInterface $link, $data)
    {
        if (empty($link->username) && !empty($data->nickname)) {
            $link->username = $ud->nickname;
            $link->save();
        }
    }
}
