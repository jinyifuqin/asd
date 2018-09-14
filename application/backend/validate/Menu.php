<?php
namespace app\backend\validate;

use think\Validate;

class Menu extends Validate
{
    protected $rule = [
        'menu_name'  => 'require',        
        'is_show' => 'in:0,1',
    ];
    protected $message = [
        'menu_name.require' => '菜单名称必须',        
        'is_show' => '必须选择显示或隐藏',        
    ];
}
