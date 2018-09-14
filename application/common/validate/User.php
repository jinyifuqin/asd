<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'user_name'  => 'require|unique:user|alphaDash|length:4,16|token',
        'user_phone' => 'require|unique:user|length:11|number',
        'user_email' => 'unique:user|email',
        'user_pass'  =>  'require|length:4,16',
        'user_pass_confirm'=>'require|confirm:user_pass',   
        'accept'      => 'require|accepted',
        // 'captcha|验证码'=>'require|captcha'
    ];
    protected $message = [
        'user_name' => '用户名必须为4~16位"-、_、数字、字母"组成！',
        'user_phone.require' => '手机号不能为空！',
        'user_phone.unique' => '手机号已被使用！',
        'user_phone.length' => '手机号格式不正确！',        
        'user_phone.number' => '手机号格式不正确！',        
        'user_pass' => '密码必须为4~16位字符！',
        'user_pass_confirm' => '两次密码不一致！',
        'accept' => '请先阅读并同意注册协议！',
    ];
    protected $scene = [
    	'register' => ['user_phone','user_pass','user_pass_confirm','accept'],
        'register_backend' => ['user_phone','user_pass','user_pass_confirm','user_email'],

        'user_pass_update'        => ['user_pass','user_pass_confirm'],
    ];
}
