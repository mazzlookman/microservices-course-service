<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternalServerErrorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        $response = $next($request);
//
//        if ($response->isServerError()){
//            return \response()->json([
//                "code" => 500,
//                "status" => "Internal Server Error",
//                "errors" => [
//                    "message" => "Ups! Something is wrong"
//                ]
//            ], 500);
//        }
//
//        return $response;
        try {
            return $next($request);

        } catch (QueryException $e) {
            return \response()->json([
                "code" => 500,
                "status" => "Internal Server Error",
                "errors" => [
                    "message" => $e->getMessage()
                ]
            ], 500);
        }
    }
}
