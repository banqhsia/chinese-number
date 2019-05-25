<?php
namespace banqhsia\ChineseNumber\Locale;

class TW extends Locale
{
    /**
     * 貨幣格式的前輟、後輟
     *
     * @var array
     */
    public static $currency_units = [
        'prepend' => '新臺幣',
        'append' => '元',
    ];

    /**
     * 大小寫數字們
     */
    public static $numbers = [
        ['○', '一', '二', '三', '四', '五', '六', '七', '八', '九'],
        ['零', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖'],
    ];

    /**
     * 每個千單位的數字們
     */
    public static $thousand = [
        ['', '十', '百', '千'],
        ['', '拾', '佰', '仟'],
    ];

    /**
     * 數字系統
     */
    public static $systems = ['', '萬', '億', '兆', '京', '垓', '秭', '壤', '溝', '澗', '正', '載'];

    /**
     * 點
     */
    public static $dot = '點';

    /**
     * 負
     */
    public static $minus = '負';

    public static function __callStatic($value, $args)
    {
        return static::$$value;
    }
}
