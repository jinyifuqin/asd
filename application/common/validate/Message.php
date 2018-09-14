<?php
namespace app\common\validate;

use think\Validate;

class Message extends Validate
{
    protected $rule = [
        'content'  => 'require',
        'user_phone' => 'require|number',        
        'captcha|验证码'=>'require|captcha'
    ];
    protected $message = [
    	'content.token' => '非法操作！',
        'content.require' => '留言内容不能为空！',
        'user_phone.require' => '手机号不能为空！',        
        'user_phone.number' => '手机号格式不正确！',                
    ];
    protected $scene = [
    	'leave' => ['content','user_phone','captcha'],        
    ];
}
