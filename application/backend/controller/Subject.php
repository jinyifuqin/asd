<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 专题
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use app\common\model\Category;

class Subject extends BackendBase
{
    public function index()
    {           
        $dataList = \app\common\model\Category::where('cate_model = 5')->order('id', 'desc')->paginate();                
        $this->assign('dataList',$dataList);
        return $this->fetch();        
    }	
   
    public function edit(){
        if($this->request->isPost()){ 
            $this->_doEdit();
        }else{
            $cateTree = $this->_getCateTree();
            $this->assign('cateTree',$cateTree);      
            $this->dataEdit = Category::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    private function _doEdit(){
        $category = new Category();
        if($category -> saveEdit()){
            \think\Cache::rm('cateTree');
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}
