<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 后台菜单
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use think\Request;
use app\common\controller\BackendBase;

class Menu extends BackendBase
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $dataList = \app\backend\model\Menu::all();
        $dataList = list_to_tree($dataList);
        $this->assign('dataList', $dataList);
        return $this->fetch();
        
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function add()
    {   
        if($this->request->isPost()){
            $menu = new \app\backend\model\Menu();
            $result = $menu ->validate(true)->saveEdit();
            if($result === false){
                $this->error($menu->getError());
            }else{
                // 添加编辑删除
                if($this->request->post('create/a')){
                    $menuSub = [];
                    $menu_link_arr = explode('/', $this->request->post('menu_link'));
                    foreach ($this->request->post('create/a') as $key => $value) {
                        $data = [];
                        switch ($value) {                        
                            case '1':
                                $data['menu_name'] = '添加';
                                $data['menu_link'] = @$menu_link_arr[0] . '/add';
                                break;
                            case '2':
                                $data['menu_name'] = '修改';
                                $data['menu_link'] = @$menu_link_arr[0] . '/edit';
                                break;
                            case '3':
                                $data['menu_name'] = '删除';
                                $data['menu_link'] = @$menu_link_arr[0] . '/delete';
                                break;
                        }                    
                        $data['is_show'] = 1;
                        $data['parent_id'] = $menu->id;
                        $menuSub[] = $data;
                    }                
                    if(!empty($menuSub)){
                        $res = $menu->saveAll($menuSub);                    
                    }
                }
                \think\Cache::rm('menuTree');
                $this->success('更新成功！','index');
            }
        }else{
            $menuTree = $this->_getTree();
            $this->assign('menuTree',$menuTree);
            return $this->fetch();
        }
    }
    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        if($this->request->isPost()){            
            $menu = new \app\backend\model\Menu();
            $result = $menu ->validate(true)->saveEdit();            
            if($result === false){
                $this->error($menu->getError());
            }else{
                \think\Cache::rm('menuTree');
                $this->success('更新成功！','index');
            }
        }else{            
            $dataEdit = \app\backend\model\Menu::get($this->request->param('id'));
            $menuTree = $this->_getTree();
            $this->assign('dataEdit', $dataEdit);
            $this->assign('menuTree',$menuTree);
            return $this->fetch();
        }
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id = ''){
        $res = \app\backend\model\Menu::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _getTree(){
        $menu = \app\backend\model\Menu::all(function($query){
            $query->field('id,menu_name,parent_id')->order('order_id', 'asc');
        });
        return list_to_tree($menu);
    }
}
