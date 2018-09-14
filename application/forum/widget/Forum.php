<?php
namespace app\forum\widget;

use app\common\controller\IndexBase;

class Forum extends IndexBase
{
    public function nav($parend_id = 0)
    {
        $navList = $this->_getNavTree();
        $this->assign('nav', $navList);
        return $this->fetch('common/nav');
    }
    public function left(){
    	$industryList = $this->_getIndustryChild();
    	$cateList = $this->_getCateChild(17);
    	
    	$this->assign('industry', $industryList);
    	$this->assign('cate', $cateList);
    	return $this->fetch('common/left');	
    }
}
