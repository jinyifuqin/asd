<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 日志
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;

class Log extends BackendBase
{
    public function backend()
    {
        $dataList = \app\backend\model\LogBackend::order('id','desc')->paginate();
        $this->assign('dataList', $dataList);
        return $this->fetch();
    }
    public function backend_edit(){
    	$dataEdit = \app\backend\model\LogBackend::get($this->request->param('id'));
        $this->assign('dataEdit', $dataEdit);
    	return $this->fetch();	
    }

    public function sms(){
        $dataList = \app\common\model\LogSms::order('id','desc')->paginate();
        $this->assign('dataList', $dataList);
        return $this->fetch();
    }
    public function mailer(){
        $dataList = \app\common\model\LogMailer::order('id','desc')->paginate();
        $this->assign('dataList', $dataList);
        return $this->fetch();
    }
}
