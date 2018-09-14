<?php
namespace app\common\model;

use think\Request;
use think\Validate;
use think\Session;
use think\Config;

use traits\model\SoftDelete;

class User extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $insert = ['create_ip'];
    public function profile()
    {
        return $this->hasOne('UserProfile','uid');
    }

    public function account()
    {
        return $this->hasOne('UserAccount','uid');
    }

    public function auth()
    {
        return $this->hasOne('UserAuth','uid');
    }

    protected function setCreateIpAttr()
    {
        return Request::instance()->ip();
    }

    protected function setUserPassAttr($value)
    {
        return $this->getPwdHash($value);
    }

    public function getShowNameAttr($value, $data)
    {
        return $data['user_name'] ? $data['user_name'] : ($data['user_phone'] ?  $data['user_phone'] : ($data['user_email'] ? $data['user_email'] : '匿名'));
    }

    public function getPwdHash($newPwd)
    {
        return md5(sha1($newPwd));
    }

    public function getLoginTimeTextAttr($value, $data)
    {
        return $data['login_time'] ? date('Y-m-d H:i:s', $data['login_time']) : '--';
    }

    public function register($data = [], $validate = 'register')
    {        
    	$data = $data ? $data : $this->request->post();
        $user = $this->validate('User.' + $validate)
            ->allowField(true)
            ->save($data);
        $validate == 'register' and $user and $this->loginUser($this->id);
        return $user;
    }

    public function login($data = [])
    {
    	$data = $data ? $data : $this->request->post();
        if(Validate::is($data['user_name'], 'email')){
            $this->where('user_email', $data['user_name']);
        }elseif(Validate::regex($data['user_name'],'/^1[3|4|5|7|8][0-9]\d{4,8}$/')){
            $this->where('user_phone', $data['user_name']);
        }elseif(!empty($data['user_name'])){
            $this->where('user_name', $data['user_name']);
        }else{
            return '账号不能为空！';
        }
        $loginRes = $this->find();
        if($loginRes && $loginRes->user_pass == $this->getPwdHash($data['user_pass'])){
            return $this->loginUser($loginRes->toArray());            
        }
        return '账号或密码有误！';        
    }
    public function loginUser($uInfo){
        if(!is_array($uInfo)){
            $uInfo = $this->get(intval($uInfo))->toArray();
        }
        if(isset($uInfo['id'])){  
            if($uInfo['status'] == 0) return '该账号已被禁用！';
            //保存用户信息和登录凭证
            Session::set('uid', $uInfo['id']);
            //更新用户数据
            $user             = self::get($uInfo['id']);
            $user->session_id = session_id();
            $user->login_expire = time() + Config::get('online_time');
            $user->login_time = time();
            $user->login_ip   = $this->request->ip();
            $user->login_times += 1;
            $user->save();
            UserMessage::send($user->id,'2');
            return true;
        }else{
            return '用户信息不存在！';
        }
    }
}
