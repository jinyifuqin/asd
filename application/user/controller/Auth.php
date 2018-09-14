<?php
namespace app\user\controller;
use app\common\controller\UserBase;
use app\common\model\User;

class Auth extends UserBase
{
    public function index()
    {
    	$user = User::get($this->uid);

        return $this->fetch('',[
        	'user' => $user,
        	]);
    }

    public function password(){
    	$request = $this->request;
    	if($request->isAjax() && $request->isPost()){
    		$user = User::get($this->uid);
    		$userPassOld = $user->getPwdHash($request->post('user_pass_old'));
    		if($userPassOld != $user->user_pass){
    			$this->error('原密码错误！');	
    		}
    		$res = $user->validate('User.user_pass_update')->allowField(['user_pass'])->save($request->post());
    		if($res){
    			$this->success('修改成功！',url('index'));
    		}
    		$this->error($user->getError());
    	}
    	return $this->fetch();
    }
}