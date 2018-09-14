<?php
// +----------------------------------------------------------------------
// | WeJoy [ 问道产品管理平台 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 http://www.zihai0531.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: TechLee <lansefengsha@hotmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
define('APP_DEBUG', true); //应用调试模式
define('IS_PUBLIC', true); //是否解析在public

define('ROOT_PATH', IS_PUBLIC ? dirname(__DIR__) . '/' : __DIR__ . '/');
define('PUBLIC_NAME', 'public');
define('APP_PATH', ROOT_PATH . 'application/'); // 定义应用目录
// define('PUBLIC_PATH', ROOT_PATH . (PUBLIC_NAME ? PUBLIC_NAME . '/' : PUBLIC_NAME)); //pubic目录

define('WEJOY_PATH' , ROOT_PATH . 'wejoy/');
define('EXTEND_PATH', WEJOY_PATH . 'extend/');
define('VENDOR_PATH', WEJOY_PATH . 'vendor/');
require WEJOY_PATH . 'thinkphp/start.php'; // 加载框架引导文件