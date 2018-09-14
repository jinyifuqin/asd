<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 登录|注册
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use think\Loader;
use think\Config;
use think\Session;
use think\Request;
class Passport extends BackendBase
{
    public function index()
    {
        $this->redirect('http://yun.longcai.com/yun/index.php?myurl=http%3A%2F%2F'.Request::instance()->server('HTTP_HOST').'%2Fbackend%2Fpassport%2Flogin.html');
    }

    public function login()
    {
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $validate = Loader::validate('Admin');
            if (!$validate->scene('login')->check($this->request->post())) {
                $this->error($validate->getError(), '');
            }
            $adminModel = new \app\backend\model\Admin();
            $password   = $adminModel->getPwdHash($password);
            $adminInfo  = $adminModel->where(['admin_name' => $username, 'password' => $password])->find();
            if (empty($adminInfo)) {
                $this->error('用户名或者密码错误！', '');
            } else {
                if ($adminInfo['status']) {
                    //保存用户信息和登录凭证
                    Session::set('admin_id', $adminInfo['id']);
                    // Cache::tag('admin_id')->set($adminInfo['id'], session_id(), config('online_time'));
                    //获取跳转链接，做到从哪来到哪去
                    // if ($this->request->has('from', 'get')) {
                        $url = $this->request->get('from');
                    // } else {
                        $url = url('Index/index');
                    // }
                    //更新用户数据
                    $adminData             = $adminModel::get(['id' => $adminInfo['id']]);
                    $adminData->session_id = session_id();
                    $adminData->login_expire = time() + (intval(Config::get('online_time')) * 60);
                    $adminData->login_time = time();
                    $adminData->login_ip   = $this->request->ip();
                    $adminData->login_times += 1;
                    $adminData->save();

                    $this->success('登录成功', $url, '', '1');
                } else {
                    $this->error('用户已被封禁，请联系管理员！', '');
                }
            }
        } else {
            Session::set('admin_id', null);
            return $this->fetch();
        }
    }

    public function logout()
    {
        Session::set('admin_id', null);
        $this->success('登出成功', url('Passport/index'));
    }
}
