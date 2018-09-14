<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 用户模块总控制器
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\common\controller;

class UserBase extends IndexBase
{
	//不需要验证登录
    private $noCheckUrl = [
        'common/*',        
    ];    
    protected function _initialize()
    {   
        parent::_initialize();
        //控制器初始化
        if (method_exists($this, '_myInit')) {
            $this->_myInit();
        }
        $this->checkLogin();
    }

    private function checkLogin(){
    	$needLogin = true;
		foreach ($this->noCheckUrl as $key => $value) {
			list($controller,$action) = explode('/', $value);
			if((strtolower($this->request->controller()) == $controller && $action == '*') || (strtolower($this->request->controller()) == $controller && strtolower($this->request->action()) == $action)){
				$needLogin = false; break;
			}
		}        
    	if($needLogin && empty($this->uid)){
    		$this->error('请先登录！');
    	}
    	
    }
}