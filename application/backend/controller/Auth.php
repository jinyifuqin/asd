<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 权限
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\backend\model\AuthGroup;
use app\backend\model\AuthRule;
use app\common\controller\BackendBase;
use permission\Permission;

class Auth extends BackendBase
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */

    public function index()
    {
        $dataList = AuthGroup::all();
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
        if ($this->request->isPost()) {
            $this->_doEdit();
        } else {
            return $this->fetch();
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    private function _doEdit()
    {
        $admin = new AuthGroup();
        if ($admin->saveEdit()) {
            $this->success('更新成功！', 'index');
        } else {
            $this->error('更新失败！');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $this->_doEdit();
        } else {
            $this->dataEdit = AuthGroup::get($this->request->param('id'));
            method_exists($this, '_editFilter') and $this->_editFilter();
            $this->assign('dataEdit', $this->dataEdit);
            return $this->fetch();
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $res = AuthGroup::destroy($id);        
        if($id != 1 && $res){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！');
        }
    }

    /**
     * 授权
     */
    public function access()
    {
        $authList = cache('AuthRule');
        if (!$authList) {
            $authList = $this->refreshAuth();
        }
        if ($this->request->isPost()) {
            $gid = session('authGid');
            if (!$gid) {
                $this->error('组ID丢失！');
            }
            $url        = $this->request->put('urlName');
            $getAuth    = $this->request->put('get');
            $putAuth    = $this->request->put('put');
            $deleteAuth = $this->request->put('delete');
            $postAuth   = $this->request->put('post');
            $auth       = Permission::AUTH_GET * $getAuth + Permission::AUTH_DELETE * $deleteAuth + Permission::AUTH_POST * $postAuth + Permission::AUTH_PUT * $putAuth;
            $authDetail = AuthRule::get(['group_id' => $gid, 'url' => $url]);
            if ($authDetail) {
                $authDetail->auth = $auth;
                $authDetail->save();
            } else {
                $newAuthDetail          = new AuthRule();
                $newAuthDetail->url     = $url;
                $newAuthDetail->group_id = $gid;
                $newAuthDetail->auth    = $auth;
                $newAuthDetail->save();
            }
            $this->success('更新成功！', url('Auth/access'), '', 1);
        } else {
            $gid = $this->request->param('id') ? $this->request->param('id') : session('authGid');
            if (!$gid) {
                $this->error('组ID丢失！');
            } else {
                session('authGid', $gid);
            }
            $authRuleArr = AuthRule::where(['group_id' => $gid])->select();
            if ($authRuleArr) {
                $authRule = [];
                foreach ($authRuleArr as $value) {
                    $authRule[$value->url] = $value->auth;
                }
                foreach ($authList as &$authValue) {
                    $authRuleValue       = isset($authRule[$authValue['menu_link']]) ? $authRule[$authValue['menu_link']] : 0;
                    $authValue['get']    = Permission::AUTH_GET & $authRuleValue;
                    $authValue['post']   = Permission::AUTH_POST & $authRuleValue;
                    $authValue['put']    = Permission::AUTH_PUT & $authRuleValue;
                    $authValue['delete'] = Permission::AUTH_DELETE & $authRuleValue;
                }
            }         
            $this->assign('dataList', $authList);
            return $this->fetch();
        }
    }
    /**
     * 刷新权限缓存
     * @param array $menu
     * @return array
     */
    public function refreshAuth($menu = [])
    {
        if (empty($menu)) {
            $menuObj = \app\backend\model\Menu::all(function ($query) {
                $query->order('order_id', 'asc');
            });
            foreach ($menuObj as $value) {
                $menuArr = $value->toArray();
                if ($menuArr['menu_link']) {
                    $menuArr['token'] = \think\Url::build($menuArr['menu_link']);
                } else {
                    $menuArr['token'] = '';
                }
                $menu[] = $menuArr;
            }
            $menu = list_to_tree($menu);
        }
        cache('AuthRule', $menu);
        return $menu;
    }
}
