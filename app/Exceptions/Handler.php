<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // ✅ Handle 404 errors
        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // ✅ Handle 403 errors
        if ($e instanceof HttpException && $e->getStatusCode() === 403) {
            return response()->view('errors.403', ['exception' => $e], 403);
        }

        // ✅ Handle 500 errors (only in production)
        if ($e instanceof \Exception && !config('app.debug')) {
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }
}
