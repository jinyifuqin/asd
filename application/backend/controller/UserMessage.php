<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 用户消息（站内信）
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;
use app\common\controller\BackendBase;
use app\common\model\UserMessage as Message;
class UserMessage extends BackendBase
{
    public function index(){        
        $dataList = Message::order('id', 'desc')->paginate();
        $this->assign('dataList',$dataList);
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
            $this->dataEdit = Message::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit',$this->dataEdit);            
            return $this->fetch();
        }
    }
    public function delete($id = ''){
        $res = Message::destroy($id);
        if($res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }
    private function _doEdit(){
        $Article = new Message();
        if($Article -> saveEdit()){
            $this->success('更新成功！','topic');
        }else{
            $this->error('更新失败！');
        }
    }
}