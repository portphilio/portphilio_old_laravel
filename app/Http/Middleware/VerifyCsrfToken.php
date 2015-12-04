<?php

namespace Portphilio\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function __construct(Illuminate\Contracts\Encryption\Encrypter $encrypter)
    {
        parent::__construct($encrypter);
        $this->except[] = config('auto-deploy.route');
    }
}
