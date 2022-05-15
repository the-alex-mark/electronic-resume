<?php

namespace App\Exceptions;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $dontReport = [];

    /**
     * @inheritDoc
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    #endregion

    /**
     * @inheritDoc
     */
    public function register() {

        // Обращение к несуществующему методу или странице
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Method not found' ], $e->getStatusCode());

            if (Auth::check())
                return redirect(RouteServiceProvider::HOME);

            return response()->view('pages.errors.404', [], $e->getStatusCode());
        });

        // Обращение к запрещённому методу или странице
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Forbidden' ], $e->getStatusCode());

            return response()->view('pages.errors.403', [], $e->getStatusCode());
        });

        // Обращение к методу, требующий аутентификацию пользователя
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Unauthorized' ], 401);

            return redirect()->route('login');
        });

        // Внутренняя ошибка сервера
        $this->renderable(function (Throwable $e, $request) {
            if (($e instanceof ValidationException))
                return null;

            if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {

                // Подробное описание ошибки при включенном режиме отладке
                if (config('app.debug', false) === true) {
                    return response()->json([
                        'result'  => false,
                        'message' => $e->getMessage(),
                        'code'    => $e->getCode(),
                        'file'    => $e->getFile(),
                        'line'    => $e->getLine(),
                        'trace'   => $e->getTrace()
                    ], 500);
                }

                return response()->json([ 'result' => false, 'message' => 'Internal Server Error' ], 500);
            }

            if (config('app.debug', false) === false)
                return response()->view('pages.errors.500', [], 500);

            return null;
        });
    }

    /**
     * @inheritDoc
     */
    public function render($request, Throwable $e) {

        // Техническое обслуживание
        if (app()->isDownForMaintenance()) {
            if ($request->wantsJson() || $request->expectsJson() || $request->ajax())
                return response()->json([ 'result' => false, 'message' => 'Service Unavailable' ], 503);

            return response()->view('pages.errors.503', [], 503);
        }

        return parent::render($request, $e);
    }

    /**
     * @inheritDoc
     */
    protected function invalidJson($request, ValidationException $exception) {
        return response()->json([
            'result'  => false,
            'message' => 'Unprocessable Content',
            'errors'  => $exception->errors()
        ], $exception->status);
    }
}
