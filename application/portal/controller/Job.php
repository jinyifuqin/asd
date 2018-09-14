<?php
namespace app\portal\controller;
use app\common\controller\PortalBase;


class Job extends PortalBase
{
    public function index()
    {   
        return $this->fetch();
    }
    public function detail()
    {   
        return $this->fetch();
    }
}
