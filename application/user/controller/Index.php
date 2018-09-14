<?php
namespace app\user\controller;

use app\common\controller\UserBase;

use app\common\model\Order;
use app\common\model\UserMessage;

class Index extends UserBase
{
    public function index()
    {   

    	$order = new Order;
    	$orderList = $order->where('uid', $this->uid)->paginate(6);

    	// 未读消息数
    	$noRead = UserMessage::where('status', 1)->where('uid',$this->uid)->count('id');
    	
        return $this->fetch('', [
        	'orderList' => $orderList,
        	'userInfo' => $this->userInfo,
        	'noRead' => $noRead,
        	]);
    }
}