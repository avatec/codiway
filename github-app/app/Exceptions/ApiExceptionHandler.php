<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiExceptionHandler extends ExceptionHandler
{
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            return new JsonResponse([
                'error' => true,
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ], $this->isHttpException($exception) ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $exception);
    }
}
