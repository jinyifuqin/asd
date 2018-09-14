<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 导航
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
class Nav extends BackendBase
{
    public function index()
    {   
        $dataList = $this->_getNavTree();
        $this->assign('dataList',$dataList);
        return $this->fetch();        
    }
    public function add()
    {   
        if($this->request->isPost()){            
            $this->_doEdit();
        }else{
            $navTree = $this->_getNavTree();
            $this->assign('navTree',$navTree);
            return $this->fetch();
        }
    }    
    public function edit(){
        if($this->request->isPost()){ 
            $this->_doEdit();
        }else{
            $navTree = $this->_getNavTree();
            $this->assign('navTree',$navTree);      
            $this->dataEdit = \app\common\model\Nav::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = \app\common\model\Nav::destroy($id);
        if($res){
            \think\Cache::rm('navTree');
            \think\Cache::rm('navTree0');
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }

    private function _doEdit(){
        $nav = new \app\common\model\Nav();
        //单个修改
        if($this->request->has('id')){
            $res = $nav -> saveEdit();
        //单个/批量添加
        }else{            
            $postData = $this->request->post();
            $nav_name_arr = explode(PHP_EOL, $postData['nav_name']);
            $insertData = [];
            foreach ($nav_name_arr as $key => $value) {
                $nav_name = preg_replace('/\s/', '', $value );
                !empty($nav_name) and $insertData[] = array_merge($postData, ['nav_name' => $nav_name]);
            }        
            $nav = new \app\common\model\Nav;
            $res = $nav->saveAll($insertData);
        }
        if($res){
            \think\Cache::rm('navTree');
            \think\Cache::rm('navTree0');
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }

}
