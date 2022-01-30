<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

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
     * @var array<int, string>
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
    public function register()
    {
        $this->renderable(function (Throwable $exception, $request) {
            $environment = env('APP_ENV');

            if ($environment === 'local' || $environment === 'development') {
                $trace = explode("\n", $exception->getTraceAsString());
                $this->setStackTrace($trace);
            }

            if ($exception instanceof HttpException) {
                return $this->responseGeneral($exception->getStatusCode(), $exception->getMessage());
            } elseif ($exception instanceof AuthenticationException) {
                return $this->responseUnauthorized($exception->getMessage());
            } else {
                return $this->responseServerError($exception->getMessage());
            }
        });
    }
}
