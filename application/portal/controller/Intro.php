<?php
/**
 * 该控制器主要用于根据GUID动态url定位
 */

namespace app\portal\controller;
use app\common\controller\PortalBase;
use app\common\model\Category;
use app\common\model\Article;

class Intro extends PortalBase
{
	public function _empty($name = '')
	{
		$this->index($name);		
	}
	public function index($guid = ''){
		$id = $this->request->has('id') ? $this->request->param('id/d') : '';
		$getCd = ['guid'=>$guid];		
		$cate = Category::get($getCd);				
		switch ($cate->cate_model) {
			case '2':
				return $this->cateList($cate);
				break;
			case '1':
			default:
				return $this->cate($cate);
				break;
		}
	}

	public function detail(){
		$cid = $this->request->has('id') ? $this->request->param('id/d') : '0' ;
		$article = Article::get($cid);	
		return $this->fetch('',['article' => $article ]);
	}

	private function cate($cate){		
		return $this->fetch('cate', ['cate' => $cate]);
	}

	private function cateList($cate){		
		$cate_id = $cate->id;
		$article = new Article;
	    $article->where(function($query) use ($cate_id) {
	        $query->where('cate_id', $cate_id)->whereOr('parent_path', 'like', '%,'.$cate_id.',%');
	    });
	    $order = ['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'];
	    $article->order($order);
	    $cateList = $article->paginate(10);
		return $this->fetch('list', [
			'cate' => $cate,
			'cateList' => $cateList,
			]);	
	}

}
