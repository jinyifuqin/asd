<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 文章
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use think\Request;
use app\common\controller\BackendBase;
use app\common\model\Category;
use think\Config;

class Article extends BackendBase
{
    protected $cateModel = 2;
    // 搜索条件
    private function _search($model){        
        $param = $this->request->only('title,cate_id,status' , 'get');
        foreach ($param as $key => $value) {
            if(is_null($value)) continue;
            switch ($key) {
                case 'title':
                    $model->where($key, 'like', '%' . $value . '%');
                    break;
                case 'cate_id':
                    $model->where(function($query) use ($key, $value) {                        
                        $query->where($key, $value)->whereOr('parent_path', 'like', '%,' . $value . ',%');
                    });                    
                    break;
                default:
                    $model->where($key, $value);
                    break;
            }
        }
        return $model;
    }
    public function index(){              
        $cateTree = $this->_getCateTree();
        $this->assign('cateTree',$cateTree);
        $article = new \app\common\model\Article;
        $article = $this->_search($article);
        // 获取文章|图文
        // $this->cateModel != 2 
        $cateId = Category::where('cate_model','eq',$this->cateModel)->column('id') 
        and $article->where('cate_id','in',$cateId);
        $dataList = $article->order('id', 'desc')->paginate('', false , [
            'query' => $this->request->get()
            ]);
        $this->assign('dataList',$dataList);        
        return $this->fetch();
    }

    public function add()
    {   
        if($this->request->isPost()){               
            $this->_doEdit();
        }else{
            $cateTree = $this->_getCateTree();            
            $this->assign('cateTree',$cateTree);
            $industryTree = $this->_getIndustryChild();            
            $this->assign('industryTree',$industryTree);
            return $this->fetch('article/add');
        }
    }
    public function edit(){
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{            
            $cateTree = $this->_getCateTree();
            $this->assign('cateTree',$cateTree);
            $this->dataEdit = \app\common\model\Article::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            $industryTree = $this->_getIndustryChild();
            $this->assign('industryTree',$industryTree);
            return $this->fetch('article/edit');
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Article::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $Article = new \app\common\model\Article();
        if($Article -> saveEdit()){
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}