<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 单页
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use app\common\model\Category;
use app\common\model\Fragment;

class Single extends BackendBase
{
    public function index()
    {           
        $dataList = \app\common\model\Category::where('cate_model = 1')->order('id', 'desc')->paginate();                
        $this->assign('dataList',$dataList);
        return $this->fetch();        
    }
    public function add()
    {   
        if($this->request->isPost()){                        
            if((new Fragment)->saveEdit()){
                $this->success('更新成功！','index');
            }else{
                $this->error('更新失败！');
            }
        }else{            
            return $this->fetch();
        }
    }   
    public function edit(){
        $cate_id = $this->request->param('id');
        if($this->request->isPost()){
            //更新碎片数据
            $data = $this->request->post('fragment/a');
            if(is_array($data)){
                $fragmentData = [];
                foreach ($data as $key => $value) {
                    $fragmentData[] = [
                        'id' => $key,
                        'content' => $value,
                    ];
                }
                $fragmentData and (new Fragment)->saveAll($fragmentData);
            }
            $this->_doEdit();
        }else{
            //碎片数据
            $fragment = Fragment::field('id,guid,title,frag_type,content')->where('cate_id', $cate_id)->select();
            $this->assign('fragment',$fragment);

            $this->dataEdit = Category::get($cate_id);
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);
            return $this->fetch();
        }
    }
    private function _doEdit(){
        $category = new Category();
        if($category -> saveEdit()){
            \think\Cache::rm('cateTree');
            $this->success('更新成功！','index');
        }else{
            $this->error('更新失败！');
        }
    }
}
