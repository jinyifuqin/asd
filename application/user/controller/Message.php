<?php
namespace app\user\controller;
use app\common\controller\UserBase;
use app\common\model\UserMessage;
use think\Config;
class Message extends UserBase
{
    public function index()
    {       	
    	    	
    	$dataList = UserMessage::where('uid', $this->uid)->order(Config::get('base.order'))->paginate(10);    	
    	$this->assign('dataList', $dataList);
        return $this->fetch();
    }
    public function item(){
    	$message = UserMessage::get(['id' => $this->request->param('id/d'),'uid' => $this->uid]);
    	if($message){
	    	$message->status = 2;
	    	$message->save();
    		$this->success($message->content);
    	}else{
    		$this->success('查看消息失败！');
    	}
    }
}