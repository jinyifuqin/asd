<?php
namespace app\portal\controller;
use app\common\controller\PortalBase;

use app\common\model\Message;

class Wejoy extends PortalBase
{
    public function contact()
    {   
    	if($this->request->isPost()){
    		$message = new Message;
            $result = $message->leave();
            if($result){
            	$this->success('留言成功！');
            }else{
            	$this->error( $message->getError() ? $message->getError() : '留言失败！');
            }
    	}
        return $this->fetch();
    } 
}
