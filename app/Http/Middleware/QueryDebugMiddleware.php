<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryDebugMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        DB::enableQueryLog();
        return $next($request);
    }

    public function terminate($request, $response) {
        // Store or dump the log data...
        $queryLogs = DB::getQueryLog();
        foreach ($queryLogs AS $queryLog) {
            echo "\n - {$queryLog['query']}";
        }
//        dd(
//                DB::getQueryLog()
//        );
    }

}
