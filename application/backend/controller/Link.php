<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 链接
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;

class Link extends BackendBase
{
	public function index()
	{
		$dataList = \app\common\model\Link::order('id', 'desc')->paginate();
		$this->assign('dataList', $dataList);
		return $this->fetch();
	}
    public function add()
    {   
    	// 
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
            $this->dataEdit = \app\common\model\Link::get($this->request->param('id'));            
            $this->assign('dataEdit',$this->dataEdit);            
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Link::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $industry = new \app\common\model\Link();
        if($industry -> saveEdit()){
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }

}