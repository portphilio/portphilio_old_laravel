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
}
