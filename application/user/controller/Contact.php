<?php
namespace app\user\controller;
use app\common\controller\UserBase;

class Contact extends UserBase
{
    public function index()
    {       	
        return $this->fetch();
    }


}