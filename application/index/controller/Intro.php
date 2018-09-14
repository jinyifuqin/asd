<?php 
namespace app\index\controller;

use app\common\controller\IndexBase;
use app\common\model\Category;
use app\common\model\Article;
/**
* 关于我们等
*/
class Intro extends IndexBase
{	
	//空操作
    public function _empty($name = '')
    {
        return $this->index($name);
    }
	public function index($cid = ''){
		$cid = $this->request->has('id') ? $this->request->param('id/d') : $cid;
		$getCd = is_int($cid) ? $cid : ['guid'=>$cid];
		$cate = Category::get($getCd);				
		switch ($cate->cate_model) {
			case '2':
			case '3':
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
	public function about(){
		return $this->index(2);
	}
}