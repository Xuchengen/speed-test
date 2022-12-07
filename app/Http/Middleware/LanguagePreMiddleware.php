<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

/**
 * 前置语言中间件
 */
class LanguagePreMiddleware
{

    //zh-CN       中国     简体
    //zh-HK       香港     繁体
    //zh-CHS      简体     简体
    //zh-CHT      繁体     繁体
    //zh-Hans     简体     简体
    //zh-Hant     繁体     繁体
    //zh-MO       澳门     繁体
    //zh-MY       大马     简体
    //zh-SG       新加坡   简体
    //zh-TW       台湾     繁体

    const LANGS = [
        'ZH'         => 'zh-cn',
        'ZH-CN'      => 'zh-cn',
        'ZH-HANS'    => 'zh-cn',
        'ZH-MY'      => 'zh-my',
        'ZH-SG'      => 'zh-sg',
        'ZH-HK'      => 'zh-hk',
        'ZH-CHT'     => 'zh-tw',
        'ZH-HANT'    => 'zh-tw',
        'ZH-MO'      => 'zh-mo',
        'ZH-TW'      => 'zh-tw',
        'ZH-HANS-CN' => 'zh-cn',
        'ZH-HANS-HK' => 'zh-cn',
        'ZH-HANS-MO' => 'zh-cn',
        'ZH-HANS-SG' => 'zh-sg',
        'ZH-HANT-HK' => 'zh-hk',
        'ZH-HANT-MO' => 'zh-mo',
        'ZH-HANT-TW' => 'zh-tw',
    ];

    public function handle(Request $request, Closure $next)
    {
        $defaultLang = 'zh-tw';
        $langKey = 'lang';
        $writeLangCookie = false;
        $lang = $request->route($langKey);
        if (empty($lang)) {
            // 从cookie中取
            $lang = strtoupper(str_replace('_', '-', Cookie::get($langKey)));
            if (empty($lang) || !array_key_exists($lang, self::LANGS)) {
                // 从请求头取
                $languages = $request->getLanguages();
                if (empty($languages)) {
                    $lang = $defaultLang;
                } else {
                    foreach ($languages as $language) {
                        $lang = strtoupper(str_replace('_', '-', $language));
                        if (!array_key_exists($lang, self::LANGS)) {
                            $lang = $defaultLang;
                        } else {
                            $lang = self::LANGS[$lang];
                            break;
                        }
                    }
                }
            } else {
                $lang = self::LANGS[$lang];
            }
        } else {
            $lang = self::LANGS[strtoupper($lang)];
            $writeLangCookie = true;
        }

        $lang = strtolower($lang);
        app()->setLocale($lang);

        // 后置处理
        $response = $next($request);

        if ($writeLangCookie) {
            $response->cookie($langKey, $lang);
        }

        return $response;
    }

}
