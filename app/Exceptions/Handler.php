<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
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
        // Handle 400 Bad Request
        if ($e instanceof HttpException && $e->getStatusCode() === 400) {
            return response()->view('errors.400', [], 400);
        }

        // Handle 401 Unauthenticated
        if ($e instanceof AuthenticationException) {
            return response()->view('errors.401', [], 401);
        }

        // Handle 403 Forbidden
        if ($e instanceof HttpException && $e->getStatusCode() === 403) {
            return response()->view('errors.403', ['exception' => $e], 403);
        }

        // Handle 404 Not Found
        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // Handle 405 Method Not Allowed
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->view('errors.405', [], 405);
        }

        // Handle 408 Request Timeout
        if ($e instanceof HttpException && $e->getStatusCode() === 408) {
            return response()->view('errors.408', [], 408);
        }

        // Handle 410 Gone
        if ($e instanceof HttpException && $e->getStatusCode() === 410) {
            return response()->view('errors.410', [], 410);
        }

        // Handle 419 Page Expired (CSRF token mismatch)
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->view('errors.419', [], 419);
        }

        // Handle 422 Unprocessable Entity (Validation)
        if ($e instanceof ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }
            
            return response()->view('errors.422', [
                'errors' => $e->errors()
            ], 422);
        }

        // Handle 429 Too Many Requests
        if ($e instanceof ThrottleRequestsException) {
            return response()->view('errors.429', [], 429);
        }

        // Handle 500 Server Error (production only)
        if ($e instanceof \Exception && !config('app.debug')) {
            return response()->view('errors.500', [], 500);
        }

        // Handle 502 Bad Gateway
        if ($e instanceof HttpException && $e->getStatusCode() === 502) {
            return response()->view('errors.502', [], 502);
        }

        // Handle 503 Service Unavailable
        if ($e instanceof HttpException && $e->getStatusCode() === 503) {
            return response()->view('errors.503', [], 503);
        }

        // Handle 504 Gateway Timeout
        if ($e instanceof HttpException && $e->getStatusCode() === 504) {
            return response()->view('errors.504', [], 504);
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->view('errors.401', [], 401);
    }
}
