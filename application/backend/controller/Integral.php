<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 积分
 * @since   2016-12-08
 * @author  TechLee < 767049337@qq.com >
 */
namespace app\backend\controller;

use think\Request;
use app\common\controller\BackendBase;
use app\common\model\Category;
use think\Config;
class Integral extends Shop
{
    public function index(){        
        $dataList = \app\common\model\Integral::order('id', 'desc')->paginate();
        $this->assign('dataList',$dataList);
        return $this->fetch();
    }
    public function add()
    {   
        if($this->request->isPost()){               
            $this->_doEdit();
        }else{
            $this->assign('cateTree',$this->_getProCateTree());            
            // $this->assign('proBrand',$this->_getProBrand());            
            return $this->fetch();
        }
    }
    public function edit(){
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{                        
            $this->assign('cateTree',$this->_getProCateTree());
            // $this->assign('proBrand',$this->_getProBrand());

            $this->dataEdit = \app\common\model\Integral::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);            
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Integral::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }

    private function _doEdit(){
        $Integral = new \app\common\model\Integral();                
        if($resId = $Integral -> saveEdit()){            
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}