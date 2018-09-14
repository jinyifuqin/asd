<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 行业
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use think\Db;
use think\Request;
use app\common\controller\BackendBase;
use app\backend\model\User;

class Industry extends BackendBase
{
    public function index()
    {   
        $dataList = $this->_getIndustryTree();
        $this->assign('dataList',$dataList);
        return $this->fetch();        
    }
    public function add()
    {   
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{
            $industryTree = \app\common\model\Industry::all(function($query){
                $query->where('parent_id', 0);
            });
            $this->assign('industryTree',$industryTree);
            return $this->fetch();
        }
    }
    public function edit(Request $request){
        if($request->isPost()){ 
            $this->_doEdit();
        }else{
            $industryTree = \app\common\model\Industry::all(function($query){
                $query->where('parent_id', 0);
            });            
            $this->assign('industryTree',$industryTree);      
            $this->dataEdit = \app\common\model\Industry::get($request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Industry::destroy($id);
        if($res){
            \think\Cache::rm('industryTree');
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $industry = new \app\common\model\Industry();
        if($industry -> saveEdit()){
            \think\Cache::rm('industryTree');
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }

}
