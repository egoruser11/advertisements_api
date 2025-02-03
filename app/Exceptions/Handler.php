<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        if (request()->wantsJson()) {
            $this->renderable(
                function (Throwable $e, Request $request) {
                    $data = app()->environment('local') ? $this->convertExceptionToArray($e) : [];
                    $data['success'] = false;
                    $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : null;
                    $headers = $this->isHttpException($e) ? $e->getHeaders() : [];

                    if ($status == Response::HTTP_UNAUTHORIZED || $e instanceof AuthenticationException) {
                        $data['message'] = 'Sorry, you are not authorized to access this data.';
                        $code = 401;
                    } elseif ($status == Response::HTTP_FORBIDDEN || $e instanceof AuthorizationException) {
                        $data['message'] = 'Sorry, you are forbidden from accessing this data.';
                        $code = 403;
                    } elseif ($status == Response::HTTP_NOT_FOUND || $e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                        $data['message'] = 'Sorry, the data you are looking for could not found .';
                        $code = 404;
                    } elseif ($status == Response::HTTP_METHOD_NOT_ALLOWED || $e instanceof MethodNotAllowedException) {
                        $data['message'] = 'Sorry, the request method is not allowed.';
                        $code = 405;
                    } elseif ($status == Response::HTTP_UNPROCESSABLE_ENTITY || $e instanceof ValidationException) {
                        $data['message'] = implode(" ", $e->validator->errors()->all());
                        $code = 422;
                    } elseif ($status == Response::HTTP_TOO_MANY_REQUESTS || $e instanceof TooManyRequestsHttpException) {
                        $data['message'] = 'Sorry, you are making too many requests to our servers.';
                        $code = 429;
                    } elseif ($status == 419 || $e instanceof TokenMismatchException) {
                        $data['message'] = 'Token mismatch';
                        $code = 419;
                    } elseif ( $e instanceof CustomException) {
                        $data['message'] = $e->getMessage();
                        $code = 422;
                    } else {
                        $data['message'] = 'Whoops, something went wrong on our servers.';
                        $code = 500;
                    }
                    $data['code'] = $code;
                    return new JsonResponse(
                        $data, $code == 500 ? 500 : 200, $headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                    );
                }
            );
        }
    }
}
