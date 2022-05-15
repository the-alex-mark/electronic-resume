<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Candidate {

    /**
     * Handle an incoming request.
     *
     * @param  Request $request Параметры запроса.
     * @param  Closure $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next) {

        /** @var User $user */
        $user = $request->user();

        if ($user->isRole('candidate')) {

            // Перенаправление на страницу создания анкеты
            if (!$request->is('summary/*')) {
                if ($user->summaries->isEmpty())
                    return redirect()->route('summary.create');
            }
        }

        return $next($request);
    }
}
