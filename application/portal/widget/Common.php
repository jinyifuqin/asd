<?php
namespace app\portal\widget;

use app\common\controller\PortalBase;

class Common extends PortalBase
{
    public function header($parend_id = 0)
    {        
        return $this->fetch('common/header');
    }
    public function footer($parend_id = 0)
    {        
        return $this->fetch('common/footer');
    }




}
