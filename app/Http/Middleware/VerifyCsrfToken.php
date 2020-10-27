<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/add',
        'api/stations/edit',
        'api/stations/delete',
        'api/stations/get',
        'api/stations/add',
        'api/users/get',
        'api/users/addStation',
        'api/users/getSuscribed',
        'api/users/deleteSuscription',
        'api/filter'
    ];
}
