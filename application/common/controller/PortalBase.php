<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * PORTAL门户总控制器
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */

namespace app\common\controller;

class PortalBase extends Base
{
    protected function _initialize()
    {    	
    	parent::_initialize();
        //控制器初始化
        if (method_exists($this, '_myInit')) {
            $this->_myInit();
        }        
    }
}
