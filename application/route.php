<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*use think\Route;
use app\common\model\Category;
//根据栏目GUID注册路由
Category::field('id,guid')->chunk(100,function($cates){
    foreach($cates as $val){
        if(empty($val->guid)) continue;
        Route::rule($val->guid.'/:id' , 'Intro/'.$val->guid);
        Route::rule($val->guid,'Intro/'.$val->guid);
    }
});
*/
/*
 * 下面返回给的是Route:rule 批量注册的参数;
 */

return [
    'marketing' => 'wejoy/marketing',
    'activity'  => 'wejoy/activity',
    'timer'  => 'index/timer',

    '[about]'   => [
        ':guid' => ['wejoy/:guid', [], ['guid' => '\w+']],
        ''      => 'wejoy/intro',
    ],

    '[news]'   => [
        ':id'   => ['news/item', [], ['id' => '\d+']],
        ':guid' => ['news/index', [], ['guid' => '\w+']],
        ''    => 'news/index',
    ],
    '[case]'   => [
        ':id'   => ['cases/item', [], ['id' => '\d+']],
        ':guid' => ['cases/index', [], ['guid' => '\w+']],
        ''    => 'cases/index',
    ],

    // 会员中心
    'login' => 'user/common/login',
    'register' => 'user/common/register',
    'logout' => 'user/common/logout',

    'my' => 'user/index/index',
];
