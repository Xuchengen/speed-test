<?php

namespace App\Http\Middleware;

use App\Helper\Chinese\ChineseConvert;
use Closure;
use Illuminate\Http\Request;

/**
 * 语言中间件
 */
class LanguageAfterMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // 后置处理
        $response = $next($request);
        $lang = app()->getLocale();

        if (ChineseConvert::is($lang, ChineseConvert::Hant)) {
            $response->setContent(ChineseConvert::to($lang, $response->getContent()));
        }

        return $response;
    }
}
