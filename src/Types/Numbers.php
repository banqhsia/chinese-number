<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Helpers\Helper;

abstract class Numbers
{

    use Helper;

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
     * 是否以大寫數字進行轉換
     *
     * @var boolean
     */
    public $case = 0;

    abstract public function handler();
    abstract public function getValue();


}
