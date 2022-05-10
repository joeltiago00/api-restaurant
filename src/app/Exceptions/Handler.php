<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper;
use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use RuntimeException;
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
     * A list of exception types that with a general message error
     * @var array|string[]
     */
    private array $defaultRenderClasses = [
//        ModelNotFoundException::class => 'exceptions.general.model-not-found'
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        if (!env('APP_DEBUG')) {
            if ($message = $this->defaultRender($e))
                return ResponseHelper::unprocessableEntity(['message' => $message]);

            return ResponseHelper::exception($e);
        }

        return parent::render($request, $e);
    }

    protected function defaultRender(Throwable $e)
    {
        $check = array_keys($this->defaultRenderClasses);

        foreach ($check as $item)
            if ($e instanceof $item)
                return trans($this->defaultRenderClasses[$item]);

        if ($e instanceof QueryException) {
            return trans('exceptions.database.query');
        }

        /**
         * To monitor handled exceptions and render a default message to user
         */
        if ($e instanceof RuntimeException) {
            /** When a log critical this case is created the specific exception should be handled */
            throw new \Exception($e);

            $error_code = Log::generate($e, LogTypes::CRITICAL);
            return trans('general.runtime-exception', ['error_code' => $error_code]);
        }

        return false;
    }
}
