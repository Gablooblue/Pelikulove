<?php

namespace App\Exceptions;

use App\Mail\ExceptionOccured;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Mail;
use Response;
use Validator;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        $enableEmailExceptions = config('exceptions.emailExceptionEnabled');
        // dd($enableEmailExceptions);

        if ($enableEmailExceptions === '') {
            $enableEmailExceptions = config('exceptions.emailExceptionEnabledDefault');
        }
        
        if ($exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException) {
            $userLevelCheck = $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException;
        }

        if ($enableEmailExceptions && $this->shouldReport($exception) && !isset($userLevelCheck)) {
            $this->sendEmail($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException) {
            $userLevelCheck = $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException;
        } elseif ($exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException) {
            $userLevelCheck = $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException;
        }

        if (isset($userLevelCheck)) {
            if ($request->expectsJson()) {
                return Response::json([
                    'error'   => 403,
                    'message' => 'Unauthorized User. Access not granted.',
                ], 403);
            } 

            return redirect('home')
                ->with([
                    'message' => 'Unauthorized User. Access not granted.',
                    'status'  => 'danger',
                ]);
        }

		if ($exception instanceof \Illuminate\Session\TokenMismatchException) {    

          // flash your message

            \Session::flash('warning-message', 'Sorry, your session seems to have expired. Please try to login again.'); 

            return redirect('login');
        }

		if ($exception instanceof \Symfony\Component\HttpFoundation\File\Exception\FileException) {
        // create a validator and validate to throw a new ValidationException
        return Validator::make($request->all(), [
            'file' => 'nullable|mimes:jpeg,jpg,png,doc,gif,pdf|max:6000',
       		 ])->validate();
    		}

   
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request                 $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Sends an email upon exception.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function sendEmail(Exception $exception)
    {
        try {
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = $handler->getHtml($e);

            Mail::send(new ExceptionOccured($html));
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}
