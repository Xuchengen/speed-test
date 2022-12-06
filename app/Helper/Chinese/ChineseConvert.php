<?php

namespace App\Helper\Chinese;

class ChineseConvert
{
    private static $PATH = __DIR__ . DIRECTORY_SEPARATOR;

    public const Hans = 'hans';

    public const Hant = 'hant';

    public const LANGS = [
        'zh-cn' => [
            'belong'   => 'hans',
            'lang'     => 'zh-cn',
            'language' => '中文简体'
        ],
        'zh-my' => [
            'belong'   => 'hans',
            'lang'     => 'zh-my',
            'language' => '大马简体'
        ],
        'zh-sg' => [
            'belong'   => 'hans',
            'lang'     => 'zh-sg',
            'language' => '新马简体'
        ],
        'zh-tw' => [
            'belong'   => 'hant-tw',
            'lang'     => 'zh-tw',
            'language' => '台灣繁體'
        ],
        'zh-hk' => [
            'belong'   => 'hant-hk',
            'lang'     => 'zh-hk',
            'language' => '香港繁體'
        ],
        'zh-mo' => [
            'belong'   => 'hant-hk',
            'lang'     => 'zh-mo',
            'language' => '澳門繁體'
        ],
    ];

    public static function to(string $lang, $str)
    {
        $language = self::LANGS[$lang];
        if (empty($language)) {
            return $str;
        }

        $belong = $language['belong'];
        if ($belong === 'hans') {
            $zh2Hans = self::getConvertEntry('zh2Hans.json');
            $zh2CN = self::getConvertEntry('zh2CN.json');
            return strtr(strtr($str, $zh2CN), $zh2Hans);
        } else if ($belong === 'hant-tw') {
            $zh2TW = self::getConvertEntry('zh2TW.json');
            $zh2Hant = self::getConvertEntry('zh2Hant.json');
            return strtr(strtr($str, $zh2TW), $zh2Hant);
        } else if ($belong === 'hant-hk') {
            $zh2HK = self::getConvertEntry('zh2HK.json');
            $zh2Hant = self::getConvertEntry('zh2Hant.json');
            return strtr(strtr($str, $zh2HK), $zh2Hant);
        }
        return $str;
    }

    public static function is(string $lang, string $who)
    {
        $language = self::LANGS[$lang];
        if (empty($language)) {
            return false;
        }

        $belong = $language['belong'];
        return str_contains($belong, $who);
    }

    private static function getConvertEntry($json_file_name)
    {
        return json_decode(file_get_contents(self::$PATH . $json_file_name), true);
    }

}
