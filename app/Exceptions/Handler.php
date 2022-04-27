<?php

namespace App\Exceptions;

use App\Helpers\ApiHelper;
use Error;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {

        // Обращение к несуществующему методу или странице
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Method not found' ], $e->getStatusCode());

            return response()->view('pages.errors.404', [], $e->getStatusCode());
        });

        // Обращение к несуществующему методу или странице
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Forbidden' ], $e->getStatusCode());

            return response()->view('pages.errors.403', [], $e->getStatusCode());
        });

        // Внутренняя ошибка сервера
        $this->renderable(function (Throwable $e, $request) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Internal Server Error' ], 500);

            if (config('app.debug', false) === false)
                return response()->view('pages.errors.500', [], 500);

            return null;
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request   $request
     * @param  Throwable $e
     * @return JsonResponse|Response|SymfonyResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e) {

        // Техническое обслуживание
        if (app()->isDownForMaintenance()) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => $e->getMessage() ], 503);

            return response()->view('pages.errors.503', [], 503);
        }

        return parent::render($request, $e);
    }
}
