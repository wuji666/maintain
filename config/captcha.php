<?php
// 验证码配置
return [
	// 验证码的字符集
	'codeSet' => '23456789abcdefghijklmnpqrstuvwxyz',
	// 字体大小
	'fontSize' => 18,
	// 是否添加混淆曲线
	'useCurve' => false,
	// 验证码图片宽度、高度
	'imageW' => 150,
	'imageH' => 35,
	// 验证码位数
	'length' => 4,
	// 验证成功后重置
	'reset' => true
];