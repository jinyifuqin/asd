<?php
namespace app\index\controller;

use think\Cache;
use app\common\controller\IndexBase;
use app\common\model\Article;
use app\common\model\Link;

class Index extends IndexBase
{
    public function index()
    {   
        // 热门搜索
        $hotLink = Cache::remember('hotLink',function(){
            return Link::all(function($query){
                $query->where('link_type', '3')->order('order_id', 'desc');
            });
        });
        $dataList = $this->caseList();    
        
        $this->assign('hotLink', $hotLink);
        $this->assign('dataList', json_encode($dataList['dataList']));                

       
        return $this->fetch();
    }
    public function caseList(){        
        $article = new Article;
        $cate_id = $this->request->has('cate_id', 'get') ? $this->request->get('cate_id') : 17;
        $article->where(function($query) use ($cate_id){
            $query->where('cate_id', $cate_id)->whereOr('parent_path', 'like', '%,' . $cate_id . ',%');
        });
        $where = [];
        $order = ['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'];
        if($this->request->get()){            
            $this->request->has('industry_id', 'get') and $where['industry_id'] = $this->request->get('industry_id');
            $this->request->has('color', 'get') and $where['color'] = $this->request->get('color');
            $this->request->has('price', 'get') and $where['price'] = $this->request->get('price');

            if($this->request->has('keywords', 'get')){
                $article->where('title', 'like', '%'.$this->request->get('keywords').'%');                                
            }

            if($this->request->has('order', 'get')){
                $order = array_merge([$this->request->get('order') => 'desc'], $order);                
            }
        }        
        $where and $article->where($where);        
        $article->order($order);        
        $dataList = $article->paginate(10);         
        foreach ($dataList as $key => $value) {
            $value->art_url = $value->art_url;
            $dataList[$key] = $value->toArray();            
        }                       
        return ['dataList' => $dataList ? $dataList : []];
    }
    public function detail(){
        $case = Article::get($this->request->param('id'));
        $case->where('id', $this->request->param('id'))->setInc('views', 1);
        $this->assign('case', $case);
    	return $this->fetch();  	
    }
}
