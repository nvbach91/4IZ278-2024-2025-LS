<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Trust every hop that sits in front of your container.
     * Railway is the only one, so this is safe.
     */
    protected $proxies = '*';

    /**
     * Honour all X-Forwarded-* headers (proto, host, for, port)
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
