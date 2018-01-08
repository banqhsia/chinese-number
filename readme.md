## ChineseNumber 中文數字轉換
一個將阿拉伯數字轉換為中文數字的套件。

## Laravel 安裝方法
1. 安裝套件

	```
	$ composer require banqhsia/ChineseNumber

	```

2. 設定 Class Alias

	```
	/*
    |-----------------------------------------------------
    | Class Aliases
    |-----------------------------------------------------
    | ...
    |
    */

    'aliases' => [
		...
        'ChineseNumber' => banqhsia\ChineseNumber\ChineseNumber::class,
    ];

	```


3. 在 Controller 內使用

	```
	<?php


	use ChineseNumber;

	class TestController extends Controller
	{
	```

## 使用方法

### 靜態呼叫


	ChineseNumber::number(25000);
	// 二萬五千

	ChineseNumber::number(17.633);
	// 十七點六三三

	ChineseNumber::number(-5040);
	// 負五千○四十

	ChineseNumber::number(5040)->minus();
	// 負五千○四十

	ChineseNumber::number(38600)->currency();
	// 新臺幣三萬八千六百元

	ChineseNumber::number(38600, 'cn')->currency();
	// 人民币三万八千六百元

	ChineseNumber::number(38600, 'hk')->currency();
	// 港幣三萬八千六百元

	ChineseNumber::number(38600, 'cn')->currency('CNY$', 'YUAN');
	// CNY$三万八千六百YUAN

	ChineseNumber::number(38000)->upper();
	// 參萬捌仟

	ChineseNumber::number(146003750)->comma();
	// 一億，四千六百萬，三千七百五十

	ChineseNumber::number(146003750)->comma('；')
	// 一億；四千六百萬；三千七百五十


### 作為物件

	$num = new ChineseNumber(25000);

	echo $num;
	// 二萬五千

	echo $num->currency();
	// 新臺幣二萬五千元

	echo $num->number(160000000, 'cn');
	// 產生新的物件
	// 一亿六千万
