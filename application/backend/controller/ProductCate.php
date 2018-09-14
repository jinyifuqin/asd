<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 产品分类
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;

class ProductCate extends BackendBase
{
	
    public function index()
    {   
        $dataList = $this->_getProCateTree();
        $this->assign('dataList',$dataList);
        return $this->fetch();        
    }
    public function add()
    {   
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{
            $cateTree = $this->_getProCateTree();            
            $this->assign('cateTree',$cateTree);
            // 产品类型
            $proType = $this->_getProType();
            $this->assign('proType',$proType);
            return $this->fetch();
        }
    }    
    public function edit(){
        if($this->request->isPost()){ 
            $this->_doEdit();
        }else{
            $cateTree = $this->_getProCateTree();
            $this->assign('cateTree',$cateTree);
            // 产品类型
            $proType = $this->_getProType();
            $this->assign('proType',$proType);
            $this->dataEdit = \app\common\model\ProductCate::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\ProductCate::destroy($id);
        if($res){
            \think\Cache::rm('proCateTree');
            $this->success('删除成功！','index');
        }else{            
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $category = new \app\common\model\ProductCate;
        if($category -> saveEdit()){
            \think\Cache::rm('proCateTree');
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}