<?php
namespace app\forum\controller;

use think\Cache;
use app\common\controller\IndexBase;
use app\common\model\ForumTopic;

class Index extends IndexBase
{
    public function index()
    {   
        $topicList = ForumTopic::order('id', 'desc')->paginate();
        $this->assign('topicList', $topicList);
        $this->_viewsTop();
        return $this->fetch();
    }
    public function detail(){
        $topic = ForumTopic::get($this->request->param('id'));
        $topic->where('id', $this->request->param('id'))->setInc('views', 1);
        $this->assign('topic', $topic);
        $this->_viewsTop();
    	return $this->fetch();  	
    }
    private function _viewsTop(){
        //精品排行
        $viewsTop = ForumTopic::order('views', 'desc')->order('id', 'desc')->paginate(8);
        $this->assign('viewsTop', $viewsTop);
    }
}
