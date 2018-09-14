<?php

namespace app\backend\model;

use app\common\model\Base;
use think\Config;
use think\Request;
class Admin extends Base
{
    protected $readonly = ['admin_name'];
	protected $insert = ['create_ip'];



    protected function setCreateIpAttr(){
        return Request::instance()->ip();
    }

    protected function setPasswordAttr($value) {
        return $this->getPwdHash($value);
    }

    public function getLoginMultiplyTextAttr($value, $data)
    {
        $status = Config::get('radio');
        return $status[$data['login_multiply']];
    }
    public function getStatusTextAttr($value, $data)
    {
        $status = Config::get('status_user');
        return $status[$data['status']];
    }


    public function getPwdHash($pwd, $authKey = '' ){
        $hashKey = empty($authKey) ? Config::get('base.auth_key') : $authKey;
        $newPwd = $pwd.$hashKey;
        return md5(sha1($newPwd).$hashKey);
    }

    public function getLoginTimeTextAttr($value, $data){
        return $data['login_time'] ? date('Y-m-d H:i', $data['login_time']) : '';
    }
    public function getOnlineTimeTextAttr($value, $data){
        return $data['online_time'] ? date('Y-m-d H:i', $data['online_time']) : '';
    }

    public function updatePassword(){
        $post = $this->request->post();        
        return $this->validate($post,'Admin.password')->allowField(true)->save($post);
    }
}
