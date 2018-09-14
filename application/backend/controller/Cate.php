<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 栏目
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use think\Db;
use think\Request;
use app\common\controller\BackendBase;
use app\common\model\Category;
use app\backend\model\User;

class Cate extends BackendBase
{
    public function index()
    {   
        $dataList = $this->_getCateTree();
        $this->assign('dataList',$dataList);
        return $this->fetch();        
    }
    public function add(Request $request)
    {   
        if($request->isPost()){            
            $this->_doEdit();
        }else{
            $cateTree = $this->_getCateTree();            
            $this->assign('cateTree',$cateTree);
            return $this->fetch();
        }
    }    
    public function edit(Request $request){
        if($request->isPost()){ 
            $this->_doEdit();
        }else{
            $cateTree = $this->_getCateTree();
            $this->assign('cateTree',$cateTree);      
            $this->dataEdit = Category::get($request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = Category::destroy($id);
        if($res){
            \think\Cache::rm('cateTree');
            $this->success('删除成功！','index');
        }else{            
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $category = new Category();
        //单个修改
        if($this->request->has('id')){
            $res = $category -> saveEdit();
        //单个/批量添加
        }else{            
            $postData = $this->request->post();
            $cate_name_arr = explode(PHP_EOL, $postData['cate_name']);
            $insertData = [];
            foreach ($cate_name_arr as $key => $value) {
                $cate_name = preg_replace('/\s/', '', $value );
                !empty($cate_name) and $insertData[] = array_merge($postData, ['cate_name' => $cate_name]);
            }        
            $category = new Category;
            $res = $category->allowField(true)->saveAll($insertData);
        }
        if($res){
            \think\Cache::rm('cateTree');
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}
