<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AdminRole;
use App\Http\Middleware\RoleCheck;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\CustomerRole;
use Illuminate\Foundation\Application;
use App\Http\Middleware\ApiAuthenticate;
use App\Http\Middleware\EmailVerification;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
        'api.auth' => ApiAuthenticate::class,
        'role.agent'=> RoleCheck::class,
        'role.admin'=> AdminRole::class,
        'role.customer'=> CustomerRole::class,
        'api.verified' => EmailVerification::class,
     ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
          
            if ($request->expectsJson()) {
            Log::error('Model Exception: ' . $e->getMessage());
    
            return response()->json([
                'message' => "The requested Resource is not found on this Server",
            ],404);
        }
        });

        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
            Log::warning('Validation failed', $e->errors());
    
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
        });
    
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
           
            Log::notice('Unauthenticated access attempt');
    
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
            }
        });
    
        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
            
            Log::warning('Wrong HTTP method used.');
        
            return response()->json([
                'message' => 'HTTP method not allowed for this route.'.$e->getMessage(),
            ], 405);
        }
        });
        
    
        $exceptions->render(function (HttpException $e, $request) {
            if ($request->expectsJson()) {
         
            Log::error('HTTP Exception: ' . $e->getMessage());
    
            return response()->json([
                'message' => $e->getMessage() ?: 'HTTP error',
            ], $e->getStatusCode());
            }
        });

    
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
            
            Log::critical('Unhandled exception: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'Server Error',
                'error' => config('app.debug') ? $e->getMessage() : 'Something went wrong',
            ], 500);
        }
        }); 
    })->create();
