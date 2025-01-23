<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $exception)
    {
        // Handle 404 Not Found Exception
        if ($exception instanceof NotFoundHttpException) {
            Log::warning('404 error encountered', ['url' => $request->url()]);
            return response()->view('errors.404', [], 404);
        }
         // Handle 403 Forbidden Exception (Unauthorized Action)
         if ($exception instanceof AccessDeniedHttpException) {
            Log::warning('403 error encountered', ['url' => $request->url()]);
            return response()->view('errors.403', [], 403);
        }
        // Handle Other HTTP Exceptions (e.g., 403, 500, etc.)
        if ($exception instanceof HttpException) {
            $status = $exception->getStatusCode();
            if (view()->exists("errors.$status")) {
                return response()->view("errors.$status", [], $status);
            }
        }
        // Default exception handling
        return parent::render($request, $exception);
    }
}
