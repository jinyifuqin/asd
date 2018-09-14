<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 后台管理员
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\backend\model\AuthGroup;
use app\backend\model\AuthGroupAccess;
use app\common\controller\BackendBase;

class Admin extends BackendBase
{
    /**
     * 显示资源列表
     */
    public function index()
    {
        $dataList = \app\backend\model\Admin::paginate();
        $this->assign('dataList', $dataList);
        return $this->fetch();
    }
    /**
     * 显示创建资源表单页.
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $this->_doEdit();
        } else {
            //会员分组
            $authGroup = authGroup::all(function ($query) {
                $query->field('id,name')->order('id', 'desc');
            });
            $this->assign('authGroup', $authGroup);
            return $this->fetch();
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     */
    public function edit()
    {
        $uid = $this->request->param('id');
        if ($this->request->isPost()) {
            $this->_doEdit();
        } else {
            //会员分组
            $authGroup = authGroup::all(function ($query) {
                $query->field('id,name')->order('id', 'desc');
            });
            $this->assign('authGroup', $authGroup);
            $this->dataEdit           = \app\backend\model\Admin::get($uid);
            $this->dataEdit->group_id = AuthGroupAccess::where('uid', $uid)->value('group_id');
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit', $this->dataEdit);
            return $this->fetch();
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     */
    public function delete($id)
    {
        $id != 1 and $res = \app\backend\model\Admin::destroy($id);
        if ($id != 1 && $res) {
            $this->success('删除成功！', 'index');
        } else {
            $this->error('删除失败！');
        }
    }

    public function password($id)
    {
        if ($this->request->isPost()) {
            $admin                  = \app\backend\model\Admin::get($id);
            $password_time          = \think\Config::get('password_time');
            $admin->password_expire = intval($password_time) > 0 ? strtotime('+' . $password_time . ' day') : '0';
            $admin->login_expire    = time();
            if ($admin->updatePassword()) {
                $this->success('修改成功！', 'index');
            } else {
                $this->success('修改失败！');
            }
        } else {
            $this->dataEdit = \app\backend\model\Admin::get($id);
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit', $this->dataEdit);
            return $this->fetch();
        }
    }
    public function my()
    {
        $admin_id = $this->admin_id;
        if ($this->request->isPost()) {
            $admin = new \app\backend\model\Admin();
            $admin = \app\backend\model\Admin::get($admin_id);
            $res   = $admin->validate('Admin.edit')->allowField(['nickname', 'avatar', 'mobile', 'email'])->save($this->request->post());
            if (!($res === false)) {
                $this->success('更新成功！');
            } else {
                $this->error($admin->getError() ? $admin->getError() : '更新失败！');
            }
        } else {
            $this->dataEdit             = \app\backend\model\Admin::get($admin_id);
            $this->dataEdit->group_id   = AuthGroupAccess::where('uid', $admin_id)->value('group_id');
            $this->dataEdit->group_name = AuthGroup::where('id', $this->dataEdit->group_id)->value('name');
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit', $this->dataEdit);
            return $this->fetch();
        }
    }
    public function my_password()
    {
        $admin_id = $this->admin_id;
        if ($this->request->isPost()) {
            $admin = \app\backend\model\Admin::get($admin_id);
            if ($admin->getPwdHash($this->request->post('password_now')) != $admin->password) {
                $this->success('原密码不一致！');
            }
            $password_time          = \think\Config::get('password_time');
            $admin->password_expire = intval($password_time) > 0 ? strtotime('+' . $password_time . ' day') : '0';
            $admin->login_expire    = time();
            if ($admin->updatePassword()) {
                $this->success('修改成功，请用新密码登录！', \think\Url::build('passport/logout'));
            } else {
                $this->success('修改失败！');
            }
        } else {
            $this->dataEdit = \app\backend\model\Admin::get($admin_id);
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit', $this->dataEdit);
            return $this->fetch();
        }
    }
    /**
     * 保存新建的资源
     *
     */
    private function _doEdit()
    {
        $admin = new \app\backend\model\Admin();
        if ($admin->validate('Admin.edit')->saveEdit()) {
            $authAccessObj = AuthGroupAccess::get(['uid' => $this->request->post('id')]);
            if (is_null($authAccessObj)) {
                $authAccessObj = new AuthGroupAccess();
            }
            $authAccessObj->group_id = $this->request->post('group_id');
            $authAccessObj->uid      = $admin->id;
            $authAccessObj->save();
            $this->success('更新成功！', 'index');
        } else {
            $this->error($admin->getError());
        }
    }
}
