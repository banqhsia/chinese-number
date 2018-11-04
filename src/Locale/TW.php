<?php
namespace banqhsia\ChineseNumber\Locale;

class TW
{
    /**
     * 貨幣格式的前輟、後輟
     *
     * @var array
     */
    static $currency_units = [
        'prepend' => '新臺幣',
        'append' => '元'
    ];

    /**
     * 大小寫數字們
     */
    static $numbers = [
        ['○', '一', '二', '三', '四', '五', '六', '七', '八', '九'],
        ['零', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖']
    ];

    /**
     * 每個千單位的數字們
     */
    static $thousand = [
        ['', '十', '百', '千'],
        ['', '拾', '佰', '仟']
    ];

    /**
     * 數字系統
     */
    static $systems = ['', '萬', '億', '兆', '京', '垓', '秭', '壤', '溝', '澗', '正', '載'];

    /**
     * 點
     */
    static $dot = '點';

    /**
     * 負
     */
    static $minus = '負';
}
