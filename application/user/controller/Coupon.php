<?php
namespace app\user\controller;
use app\common\controller\UserBase;

class Coupon extends UserBase
{
    public function index()
    {       	
        return $this->fetch();
    }
}