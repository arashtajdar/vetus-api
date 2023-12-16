<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

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
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ApiResponse::error('Resource not found', 404);
        }
        if ($exception instanceof RouteNotFoundException) {
            return response()->json(['error' => 'Route not found'], 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Method not allowed'], 405);
        }
        if ($exception instanceof ValidationException) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
        if ($exception instanceof QueryException) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
        if ($exception instanceof ClientException) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
        return parent::render($request, $exception);
    }
}
