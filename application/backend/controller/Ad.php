<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 广告
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;

class Ad extends BackendBase
{
   
	public function index()
	{
		$dataList = \app\common\model\Ad::paginate();
		$this->assign('dataList', $dataList);
		return $this->fetch();
	}
    public function add()
    {   
    	// 
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
            $this->dataEdit = \app\common\model\Ad::get($this->request->param('id'));            
            $this->assign('dataEdit',$this->dataEdit);            
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Ad::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $industry = new \app\common\model\Ad();
        if($industry -> saveEdit()){
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }


    //广告列表
    public function ad_list(){
        $dataList = \app\common\model\AdList::paginate();
        $this->assign('dataList', $dataList);
        return $this->fetch();
    }
    public function ad_add()
    {   
        if($this->request->isPost()){               
            $this->_doAdEdit();
        }else{        
            //广告位置
            $ad = \app\common\model\Ad::all(function($query){
                $query->field('id,ad_name')->order('order_id', 'desc');
            });            
            $this->assign('ad',$ad);       
            return $this->fetch();
        }
    }
    public function ad_edit(){
        if($this->request->isPost()){            
            $this->_doAdEdit();
        }else{                        
            //广告位置
            $ad = \app\common\model\Ad::all(function($query){
                $query->field('id,ad_name')->order('order_id', 'desc');
            });            
            $this->assign('ad',$ad);            

            $this->dataEdit = \app\common\model\AdList::get($this->request->param('id'));            
            $this->assign('dataEdit',$this->dataEdit);            
            return $this->fetch();
        }
    }
    public function ad_delete($id = ''){
        $res = \app\common\model\AdList::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doAdEdit(){
        $industry = new \app\common\model\AdList();
        if($industry -> saveEdit()){
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}