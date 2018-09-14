<?php
namespace app\common\model;

use think\Request;

use traits\model\SoftDelete;

class UserMessage extends Base
{
	use SoftDelete;
	protected $insert = ['create_ip'];

	protected function getStatusTextAttr($value, $data){
		return $data['status'] == 1 ? '未读' : '已读';
	}

    protected function setCreateIpAttr(){
        return Request::instance()->ip();
    }

	public static function send($uid,$type){
		$message = new UserMessage;
		$msgTpl = self::tpl($type);
		$message->uid = $uid;
		$message->title = $msgTpl['title'];
		$message->content = $msgTpl['content'];
		return $message->save();
	}

	public static function tpl($type){
		$msg = [
			'title' => '',
			'content' => '',
		];
		switch ($type) {
			case '1':
				$msg['title'] = '注册成功';
				$msg['content'] = '尊敬的朋友，欢迎您加入本平台！';
				break;
			case '2':
				$msg['title'] = '欢迎登录';
				$msg['content'] = '尊敬的朋友，欢迎登录！';
				break;
			default:
				# code...
				break;
		}
		return $msg;
	}
}
