<?php
namespace app\wap\controller;
use app\common\controller\WapBase;

class News extends WapBase
{
    public function index()
    {   
        return $this->fetch();
    }
    public function index_ajax(){
    	$cate_id = $this->request->param('id/d') ? $this->request->param('id/d') : 36;    	
    	$dataList = get_article_list($cate_id,8);
    	$this->assign('dataList', $dataList);    	    	
    	return ['html' => $this->fetch() , 'lastPage' => $dataList->lastPage()];
    }
    public function detail()
    {   
        return $this->fetch();
    }
}
