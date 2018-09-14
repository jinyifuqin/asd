<?php
namespace app\forum\widget;

use app\common\controller\IndexBase;
use app\common\model\ForumTopic;
use think\Cache;
class Topic extends IndexBase
{
    public function hotTags($parend_id = 0)
    {
    	// 热门标签        
    	if(!($hotTags = Cache::get('topicHotTags'))){
            $tagsArr = ForumTopic::column('tags');
	        $hotTags = [];
	        foreach ($tagsArr as $value) {            
	            $valueArr = explode(',', str_replace(['，','|','、',' '], ',', $value));
	            foreach ($valueArr as $value) {
	                isset($hotTags[$value]) ? $hotTags[$value]++ : ($hotTags[$value] = 1);
	            }
	        }
	        arsort($hotTags);
	        $hotTags = array_slice($hotTags, 0,16);  
	        Cache::set('topicHotTags', $hotTags, 3600);          
    	}

        $this->assign('hotTags', $hotTags);
        return $this->fetch('topic/hotTags');
    }
    public function left(){
    	$industryList = $this->_getIndustryChild();
    	$cateList = $this->_getCateChild(17);
    	
    	$this->assign('industry', $industryList);
    	$this->assign('cate', $cateList);
    	return $this->fetch('common/left');	
    }
}
