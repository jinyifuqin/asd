<?php
namespace app\portal\controller;

use app\common\controller\PortalBase;


class Index extends PortalBase
{
    public function index()
    {   
        return $this->fetch();
    }
    public function about(){        
    	return $this->fetch();
    }
    public function timer(){        
    	return $this->fetch();
    }
}
