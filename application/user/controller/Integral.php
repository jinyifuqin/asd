<?php
namespace app\user\controller;
use app\common\controller\UserBase;

use app\common\model\UserAccountLog as Log;

class Integral extends UserBase
{
    public function index()
    {   
    	// 积分记录
    	$dataList = Log::where('log_type', 'like', '2%')->order('id','desc')->paginate(5);
        return $this->fetch('',[
        	'dataList' => $dataList,
        	]);
    }
}