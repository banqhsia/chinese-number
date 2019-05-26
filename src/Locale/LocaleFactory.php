<?php
namespace banqhsia\ChineseNumber\Locale;

class LocaleFactory
{
    // TODO: Setting to TW in order to make sure setLocale() works.
    public static $locale = TW::class;

    public static $localeList = [
        'tw' => TW::class,
        'cn' => CN::class,
        'hk' => HK::class,
    ];

    /**
     * 設定語系
     *
     * @param string $locale
     */
    public static function createLocale($locale)
    {
        $locale = strtolower($locale);

        if (! array_key_exists(strtolower($locale), static::$localeList)) {
            throw new \InvalidArgumentException("Locale \"{$locale}\" is not supported.");
        }

        return static::$locale = new static::$localeList[$locale];
    }

    /**
     * 將靜態呼叫的方法代理至指定語系的靜態屬性
     *
     * @param string $value
     * @param array $args
     *
     * @return string
     */
    public static function __callStatic($value, $args)
    {
        return static::$locale::$$value;
    }
}
