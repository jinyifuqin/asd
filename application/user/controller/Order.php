<?php
namespace app\user\controller;
use app\common\controller\UserBase;

class Order extends UserBase
{
    public function index()
    {       	
        return $this->fetch();
    }
    public function item(){
    	return $this->fetch();	
    }
}