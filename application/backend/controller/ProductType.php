<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 产品类型
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use app\common\model\ProductSpec;
class ProductType extends BackendBase
{
	
	public function index()
	{		
		$dataList = \app\common\model\ProductType::order('order_id desc , id desc')->paginate();        
		$this->assign('dataList', $dataList);
		return $this->fetch();
	}
    public function add()
    {   
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{            
            $this->assign('allSpec', ProductSpec::column('spec_name','id'));
            return $this->fetch();
        }
    }    
    public function edit(){
        if($this->request->isPost()){
            $this->_doEdit();
        }else{            
            $this->assign('allSpec', ProductSpec::column('spec_name','id'));
            
            $this->dataEdit = \app\common\model\ProductType::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\ProductType::destroy($id);
        if($res){            
            $this->success('删除成功！','index');
        }else{            
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){    	
        $category = new \app\common\model\ProductType;
        if($resId = $category -> saveEdit()){        	
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}