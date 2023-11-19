<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * When unauthenticaticated user can register then pass exception.
     *
     * @return void
     */
    public function unauthenticated($error, $errorMessages = [], $code = 203)
    {
        if(request()->expectsJson()) {
            $response = [
                'success' => "false",
                'code' => $code,
                'message' => Lang::get('messages.UNAUTHORIZED_MSG'),
            ];
            return response()->json($response, $code);
        }
        return redirect()->guest(route('login'));
    }
}
