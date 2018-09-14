<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 产品
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use think\Request;
use app\common\controller\BackendBase;
use app\common\model\Category;
use think\Config;
class Product extends Shop
{
    public function index(){        
        $dataList = \app\common\model\Product::order('id', 'desc')->paginate();
        $this->assign('dataList',$dataList);
        return $this->fetch();
    }
    public function add()
    {   
        if($this->request->isPost()){               
            $this->_doEdit();
        }else{
            $this->assign('cateTree',$this->_getProCateTree());            
            $this->assign('proBrand',$this->_getProBrand());            
            return $this->fetch();
        }
    }
    public function edit(){
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{                        
            $this->assign('cateTree',$this->_getProCateTree());
            $this->assign('proBrand',$this->_getProBrand());

            $this->dataEdit = \app\common\model\Product::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);            
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Product::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }

    public function get_spec(){
        $cate_id = $this->request->param('cate_id');
        $spec =  \app\common\model\ProductCate::get($cate_id);
        return $spec->specVal;
    }

    private function _doEdit(){
        $Article = new \app\common\model\Product();        
        $proSpec = $this->request->post('pro_spec/a');
        $proId = $this->request->post('id');
        if($resId = $Article -> saveEdit()){
            //规格值保存
            if($proSpec){
                $proId = $proId ? $proId : @$resId;                
                foreach ($proSpec as $key => $value) {
                    $proSpec[$key]['pro_id'] = $proId;                    
                }                               
                $productExt = new \app\common\model\ProductExt;                          
                $productExt->saveAll($proSpec);
                //更新价格
                $product = \app\common\model\Product::get($proId);                
                $product->price < 0.01 
                and $product->price = min(array_column($proSpec, 'spec_price')) 
                and $product->save();
            }

            $this->success('更新成功！','index');
            
        }else{
            $this->error('更新失败！');
        }
    }
}