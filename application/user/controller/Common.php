<?php
namespace app\user\controller;

use think\Session;
use app\common\controller\UserBase;
use app\common\model\User;

class Common extends UserBase
{
    public function login()
    {   
        if($this->uid){
            $this->redirect('User/Index/index');
        }
        $request = $this->request;
        if($request->isAjax() && $request->isPost()){
            $user = new User;
            $result = $user->login();
            if($result === true){
                $this->success('登录成功！','User/Index/index');
            }else{
                $this->error($result);
            }
        }
        return $this->fetch();
    }

    public function register()
    {   
    	$request = $this->request;
    	if($request->isAjax() && $request->isPost()){
            $user = new User;
            $result = $user->register();
            if($result){
                $this->success('注册成功！','User/Index/index');
            }else{
                $this->error($user->getError());                
            }
    	}
        return $this->fetch();
    }

    public function logout()
    {
        Session::set('uid', null);         
        $this->success('登出成功', url('user/common/login'));
    }
}