<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 论坛
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use think\Request;
use app\common\controller\BackendBase;
use app\common\model\Category;
use think\Config;
class Forum extends BackendBase
{
    public function topic(){        
        $dataList = \app\common\model\ForumTopic::order('id', 'desc')->paginate();
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
            // dump($industryTree);die;
            $this->assign('industryTree',$industryTree);
            return $this->fetch();
        }
    }
    public function edit(){
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{            
            $cateTree = $this->_getCateTree();
            $this->assign('cateTree',$cateTree);
            $this->dataEdit = \app\common\model\ForumTopic::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            $industryTree = $this->_getIndustryChild();
            $this->assign('industryTree',$industryTree);
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\ForumTopic::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $Article = new \app\common\model\ForumTopic();
        if($Article -> saveEdit()){
            $this->success('更新成功！','topic');
        }else{
            $this->error('更新失败！');
        }
    }
}