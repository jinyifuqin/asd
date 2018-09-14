<?php
namespace app\portal\controller;
use app\common\controller\PortalBase;


class Cases extends PortalBase
{
    public function index()
    {   
        return $this->fetch();
    }
    public function item()
    {   
        return $this->fetch();
    }
}
