<?php
namespace app\user\controller;
use app\common\controller\UserBase;
use app\common\model\UserDeliver;

class Deliver extends UserBase
{
    public function index()
    {       	
    	if($this->request->isAjax() && $this->request->isPost()){
    		$userProfile = new UserDeliver;
    		$data = $this->request->post();    		
    		if(UserDeliver::get(['uid'=>$this->uid])){
    			$userProfile->isUpdate(true)->where(['uid'=>$this->uid]);
    		}else{
	    		$data['uid'] = $this->uid;
    		}
    		if($userProfile->data($data,true)->allowField(true)->save()){
    			$this->success('更新成功！',url('index'));
    		}    		
    		$this->error($user->getError());
    	}
    	$deliver = UserDeliver::get(['uid'=>$this->uid]);
        return $this->fetch('', [
        	'deliver' => $deliver,
        	]);
    }


}