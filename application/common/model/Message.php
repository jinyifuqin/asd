<?php
namespace app\common\model;

use think\Model;
use think\Config;
class Message extends Base
{
	public function getTypeTextAttr($value, $data){
    	$message_type = Config::get('base.message_type');
		return @$message_type[$data['type']];
    }

    public function leave($data = [])
    {    	
    	$data = $data ? $data : $this->request->post();
        return $this->validate('Message.leave')
            ->allowField(true)
            ->save($data);
    }
}

