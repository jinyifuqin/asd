<?php
namespace app\backend\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username'  => 'require|max:25|token',
        'admin_name' => 'unique:admin',
        'password'  =>  'require',
        'captcha|验证码'=>'require|captcha'
    ];
    protected $message = [
        'username.require' => '用户名必须',
        'password.require' => '密码必须',

        'admin_name.unique' => '用户名已存在！',        
    ];
    protected $scene = [
    	'login' => ['username', 'password', 'captcha'],
    	'password' => ['password'=>'require|confirm'],
    	'edit' => ['admin_name'],
    ];
}
