<?php
namespace banqhsia\ChineseNumber\Locale;

class Locale
{
    public static $locale = TW::class;

    public static $locale_list = [
        'tw' => TW::class,
        'cn' => CN::class,
        'hk' => HK::class,
    ];

    /**
     * 設定語系
     *
     * @param string $locale
     */
    public static function setLocale($locale)
    {
        $locale = strtolower($locale);

        if (!array_key_exists(strtolower($locale), static::$locale_list)) {
            throw new \Exception("Locale \"{$locale}\" is not supported.");
        }

        return static::$locale = static::$locale_list[$locale];
    }

    /**
     * 將靜態呼叫的方法代理至指定語系的靜態屬性
     *
     * @param string $value
     * @param array $args
     */
    public static function __callStatic($value, $args)
    {
        return static::$locale::$$value;
    }
}
