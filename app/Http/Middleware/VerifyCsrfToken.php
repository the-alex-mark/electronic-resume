<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {

    #region Properties

    /**
     * @inerhitDoc
     */
    protected $except = [];

    #endregion

    /**
     * @inheritDoc
     */
    public function handle($request, Closure $next) {
        if (config('app.verify_csrf', true) !== false)
            return parent::handle($request, $next);

        return $next($request);
    }
}
