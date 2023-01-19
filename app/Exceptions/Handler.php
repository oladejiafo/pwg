<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

use Throwable;

class Handler extends ExceptionHandler
{
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($this->isHttpException($e)) {
            switch ($e->getStatusCode()) {
                    // not found
                case 404:
                    return Redirect::to('https://pwggroup.ae/404');
                    break;

                    // internal error
                case '500':
                    return Redirect::to('https://pwggroup.ae/404');
                    break;

                    // authentication error
                case '403':
                    return Redirect::to('https://pwggroup.ae/404');
                    break;

                case '419':
                    return Redirect::to('https://pwggroup.ae/404');
                    break;

                case '405':
                    return Redirect::to('https://pwggroup.ae/404');
                    break;

                default:
                    return $this->renderHttpException($e);
                    break;
            }
        } else {
            // if ($e instanceof ValidationException) {
                return parent::render($request, $e);
            // }
            // if (Auth::id()) {
            //     return redirect()->guest('myapplication');
            // } else {
            //     if (isset($request['signature']) && isset($request['expires'])) {
            //         return parent::render($request, $e);
            //     } else {
            //         return redirect()->guest('/');
            //     }
            // }
        }
    }
}
