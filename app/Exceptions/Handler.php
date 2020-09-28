<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException){
            return response()->json([
                'res' => false,
                'error' => "Error de modelo"
            ], 400);
        }
        if($exception instanceof QueryException){
            return response()->json([
                'res' => false,
                'error' => "Error de consulta de BDD ".$exception->getMessage()
            ], 500);
        }
        if($exception instanceof HttpException){
            return response()->json([
                'res' => false,
                'error' => "Error de ruta"
            ], 404);
        }
        if($exception instanceof AuthenticationException){
            return response()->json([
                'res' => false,
                'error' => "Error de autenticación"
            ], 401);
        }
        if($exception instanceof AuthorizationException){
            return response()->json([
                'res' => false,
                'error' => "Error de autorización, no tienes permisos"
            ], 403);
        }
        return parent::render($request, $exception);
    }
}
