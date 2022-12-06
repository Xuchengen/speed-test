<?php

namespace App\Http;

use App\Http\Middleware\LanguageAfterMiddleware;
use App\Http\Middleware\LanguagePreMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\ThrottleRequests;

class Kernel extends HttpKernel
{

    protected $middleware = [
        PreventRequestsDuringMaintenance::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class
    ];

    protected $middlewareGroups = [
        'web' => [
            LanguagePreMiddleware::class,
            LanguageAfterMiddleware::class,
        ],

        'api' => [
        ],
    ];

    // 路由中间件
    protected $routeMiddleware = [
        'throttle'      => ThrottleRequests::class,
        'cache.headers' => SetCacheHeaders::class,
    ];
}
