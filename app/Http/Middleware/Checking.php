<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Checking {

    /**
     * Handle an incoming request.
     *
     * @param  Request $request Параметры запроса.
     * @param  Closure $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if ($request->user()->isRole('candidate'))
            abort(404);

        return $next($request);
    }
}
