<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 产品规格
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;

class ProductSpec extends BackendBase
{
	
	public function index()
	{		
		$dataList = \app\common\model\ProductSpec::order('order_id desc , id desc')->paginate();        
		$this->assign('dataList', $dataList);
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
            $this->dataEdit = \app\common\model\ProductSpec::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\ProductSpec::destroy($id);
        if($res){            
            $this->success('删除成功！','index');
        }else{            
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
    	$specValData = $this->request->post('spec_val/a');
    	$specId  = $this->request->post('id');
        $category = new \app\common\model\ProductSpec;
        if($resId = $category -> saveEdit()){
        	//规格值保存
        	if($specValData){
        		$specId = $specId ? $specId : $resId;
        		$updateId = [];
	    		foreach ($specValData as $key => $value) {
	    			$specValData[$key]['spec_id'] = $specId;
	    			!empty($value['id']) and $updateId[] = intval($value['id']);
	    		}	    			    		
		        $specVal = new \app\common\model\ProductSpecVal;
		        !empty($updateId) and $specVal->where('spec_id','=',$specId)->where('id','not in',$updateId)->delete();
		        $specVal->saveAll($specValData);
	    	}
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}