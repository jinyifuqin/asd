<?php
namespace app\wap\widget;
use app\common\controller\WapBase;
class Common extends WapBase
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
