<?php
namespace app\portal\controller;
use app\common\controller\PortalBase;


class About extends PortalBase
{
    public function about()
    {   
        return $this->fetch();
    }    
    public function contact()
    {   
        return $this->fetch();
    }
}
