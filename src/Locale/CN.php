<?php
namespace banqhsia\ChineseNumber\Locale;

class CN extends Locale
{
    /**
     * 貨幣格式的前輟、後輟
     *
     * @var array
     */
    static $currency_units = [
        'prepend' => '人民币',
        'append' => '元',
    ];

    /**
     * 大小寫數字們
     */
    static $numbers = [
        ['○', '一', '二', '三', '四', '五', '六', '七', '八', '九'],
        ['零', '壹', '贰', '参', '肆', '伍', '陆', '柒', '捌', '玖'],
    ];

    /**
     * 每個千單位的數字們
     */
    static $thousand = [
        ['', '十', '百', '千'],
        ['', '拾', '佰', '仟'],
    ];

    /**
     * 數字系統
     */
    static $systems = ['', '万', '亿', '兆', '京', '垓', '秭', '壤', '沟', '涧', '正', '载'];

    /**
     * 點
     */
    static $dot = '点';

    /**
     * 負
     */
    static $minus = '负';

    public static function __callStatic($value, $args)
    {
        return static::$$value;
    }
}
