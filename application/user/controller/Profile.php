<?php
namespace app\user\controller;
use app\common\controller\UserBase;
use think\Validate;
use app\common\model\User;
use app\common\model\UserProfile;

class Profile extends UserBase
{
    public function index()
    {       
    	$request = $this->request;
    	if($request->isAjax() && $request->isPost()){
    		if(Validate::regex($request->post('user_name'),'[a-zA-Z\d+]{6,16}')){
	    		$user = User::get($this->uid);
	    		$user->user_name = $request->post('user_name');
	    		$user->save();
    		}elseif(!empty($request->post('user_name'))){
    			$this->error('用户名为6~16位数字和字母组成！');
    		}
    		$userProfile = new UserProfile;
    		$data = $request->post();    		
    		if(UserProfile::get(['uid'=>$this->uid])){
    			$userProfile->isUpdate(true)->where(['uid'=>$this->uid]);
    		}else{
	    		$data['uid'] = $this->uid;
    		}
    		if($userProfile->data($data,true)->allowField(true)->save()){
    			$this->success('修改成功！',url('index'));
    		}    		
    		$this->error($user->getError());
    	}

     	return $this->fetch('',[
     		'user' => $this->userInfo,
     		]);
    }
}