<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 招聘
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use think\Config;
class Job extends BackendBase
{
    public function index(){        
        $dataList = \app\common\model\Job::order('id', 'desc')->paginate();
        $this->assign('dataList',$dataList);        
        return $this->fetch();
    }
    public function add()
    {   
        if($this->request->isPost()){               
            $this->_doEdit();
        }else{            
            return $this->fetch();
        }
    }
    public function edit(){
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{            
            $cateTree = $this->_getCateTree();
            $this->assign('cateTree',$cateTree);
            $this->dataEdit = \app\common\model\Job::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            $industryTree = $this->_getIndustryChild();
            $this->assign('industryTree',$industryTree);
            return $this->fetch();
        }
    }
    public function doEdit(){
        $article = new \app\common\model\Job;
        if($article -> saveEdit()){
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Job::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $Article = new \app\common\model\Job();
        if($Article -> saveEdit()){
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}