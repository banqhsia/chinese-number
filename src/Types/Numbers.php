<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Helpers\Helper;

abstract class Numbers
{

    use Helper;

    /**
     * 是否以大寫數字進行轉換
     *
     * @var boolean
     */
    public $case = 0;

    /**
     * (抽象方法) 各數值的處理方法
     *
     * @return string
     */
    abstract public function handler();

    /**
     * (抽象方法) 取得結果字串
     *
     * @return mixed
     */
    abstract public function getValue();


}
