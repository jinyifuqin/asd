<?php
namespace app\index\widget;

use app\common\controller\IndexBase;

class Common extends IndexBase
{
    public function header($parend_id = 0)
    {        
    	$this->assign('uid', $this->uid);
        return $this->fetch('index@common/header');
    }
    public function footer($parend_id = 0)
    {        
        return $this->fetch('index@common/footer');
    }
}
