<?php

namespace Portphilio;

use Illuminate\Database\Eloquent\Model;

class Artifact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'thumbnail',
        'type',
        'description',
        'user_id',
        'from',
        'to',
    ];

    /**
     * The owner of the artifact.
     *
     * @return Portphilio\User The owner of the artifact
     */
    public function user()
    {
        return $this->belongsTo('Portphilio\User');
    }

    /**
     * Set the date of the "to" field appropriately to a date or null.
     *
     * @param string $value A string that can be parsed as a date, or an empty string
     */
    public function setToAttribute($value)
    {
        $this->attributes['to'] = $this->dateValue($value);
    }

    /**
     * Set the date of the "from" field appropriately to a date or null.
     *
     * @param string $value A string that can be parsed as a date, or an empty string
     */
    public function setFromAttribute($value)
    {
        $this->attributes['from'] = $this->dateValue($value);
    }

    /**
     * Converts a value to either a valid date string or null;.
     *
     * @param string $value A string that can be parsed as a date, or an empty string
     *
     * @return mixed Returns null or a date formatted for MySQL
     */
    private function dateValue($value)
    {
        if (false !== strtotime($value)) {
            return date('Y-m-d h:i:s', strtotime($value));
        } else {
            return;
        }
    }
}
