<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 后台总控制器
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\common\controller;
use think\Config;
use think\Cache;
use think\Session;
use think\Url;
use app\backend\model\Admin;
use app\backend\model\Menu;
class BackendBase extends Base
{
    protected $admin_id;
    protected $adminInfo;
    protected $menuInfo;
    protected $url;
    //超级url，不验证登录，不验证权限
    private $superUrl = [
        'Passport/index',
        'Passport/login',
        'Passport/logout',
    ];
    //不需要验证权限，需要验证登录
    private $noCheckUrl = [
        'Index/index',
        'Index/dashboard',
        'Index/clear',
        'Ueditor/index',
        'Product/get_spec',
    ];
    protected function _initialize()
    {
        parent::_initialize();
        //初始化系统
        $this->admin_id = Session::get('admin_id');
        $this->assign('admin_id', $this->admin_id);
        $this->iniSystem();
        //控制器初始化
        if (method_exists($this, '_myInit')) {
            $this->_myInit();
        }
    }
    /**
     * 系统初始化函数（登陆状态检测，权限检测，初始化菜单）
     */
    private function iniSystem()
    {
        $this->url = $this->request->controller() . '/' . $this->request->action();
        if (in_array($this->url, $this->superUrl) || in_array($this->url, $this->noCheckUrl)) {
            if (!in_array($this->url, $this->superUrl)) {
                $this->checkLogin();
            }
        } else {
            $map = ['menu_link' => $this->url];
            if(!Config::get('app_debug')){
                $map['development'] = ['neq', '1'];//开发环境才显示开发者菜单
            }
            $this->menuInfo = Menu::where($map)->find();
            if (is_null($this->menuInfo)) {
                $this->assign('status_code', '404');
                $this->error('页面：' . $this->url . '不存在！');
            }
            $this->checkLogin();
            $this->checkAdminInfo();
            $this->checkRule();
        }
    }
    /**
     * 用户登录状态检测
     */
    private function checkLogin()
    {
        if (isset($this->admin_id) && !empty($this->admin_id)) {

            // $sidOld = Cache::get($this->admin_id);
            // if (isset($sidOld) && !empty($sidOld)) {
                // if ($sidOld != $sidNow) {
                //     $this->error("您的账号在别的地方登录了，请重新登录！", Url::build('Passport/login'));
                // } else {
                    // cache($this->admin_id, $sidNow, config('online_time'));
                    $sidNow = session_id();
                    $admin = Admin::get(['id' => $this->admin_id]);
                    if(!$admin->login_multiply && $admin->session_id != $sidNow){
                        $this->error("您的账号在别的地方登录了，请重新登录！", Url::build('Passport/index'));
                    }elseif (empty($admin->login_expire) || $admin->login_expire < time()) {
                        $this->error("登录超时，请重新登录！", Url::build('Passport/index'));
                    }elseif($admin->status == 0){
                        $this->error("您的账号已被封禁，请联系管理员！", Url::build('Passport/index'));
                    }else{
                        $admin->login_expire = time() + (intval(Config::get('online_time')) * 60);
                        $admin->online_time = time();
                        $admin->save();
                        $this->adminInfo = $admin;
                    }
                // }
            // } else {
                // $this->error("登录超时，请重新登录！", Url::build('Passport/index'));
            // }
        } else {
            $this->redirect('Passport/index');
        }
    }
    /**
     * 检查密码是否过期、是否需要修改密码、设置昵称
     */
    private function checkAdminInfo(){
        // 密码是否过期
        if ($this->url != 'Admin/my_password' &&
            $this->url != 'Index/index' &&
            $this->url != 'Index/dashboard' &&
            $this->adminInfo['password_expire'] != 0 &&
            $this->adminInfo['password_expire'] < time()
            ) {
            $this->error('密码已过期！', Url::build('Admin/my_password'));
        }
        if ($this->adminInfo['update_time'] === 0 && $this->url != 'Admin/my_password') {
            // $this->error('初次登录请重置用户密码！', Url::build('admin/my_password'));
        } else {
            if (empty($this->adminInfo['nickname'])  && $this->url != 'Admin/my') {
                // $this->error('初次登录请设置用户昵称！', Url::build('admin/my'));
            }
        }
    }
    /**
     * 权限检测&权限验证
     */
    private function checkRule()
    {
        $check = (new \permission\Permission())->check($this->url, $this->admin_id);
        if (!$check) {
            $this->error('对不起，您没有权限！', Url::build('index/dashboard'));
        }
        $this->record();
    }
    //记录日志
    protected function record($admin_id = '', $admin_name = '', $menu_name = ''){
        $menuColumn = Cache::remember('menuColumn',function(){
            return Menu::order('order_id', 'desc')->column('menu_name','id');
        });
        if(!$menu_name){
            $parentIdArr = explode(',', $this->menuInfo['parent_path']);
            $menu_name = '';
            foreach ($parentIdArr as $value) {
                $menu_name .= (isset($menuColumn[$value]) && $value) ? $menuColumn[$value] . '- ' : '';
            }
            $menu_name .= $this->menuInfo['menu_name'];
        }
        $log = new \app\backend\model\LogBackend;
        $log->admin_id   = $admin_id ? $admin_id : $this->admin_id;
        $log->admin_name = $admin_name ? $admin_name : $this->adminInfo['admin_name'];
        $log->menu_name  = $menu_name;
        $log->request_url = $this->url;
        $log->save();
    }
    protected function _editFilter($id = '')
    {
    }
    protected function _getMenuChild(){
        return Cache::remember('menuChild',function(){
            $menu = [];
            $map = ['is_show' => '1'];
            if(!Config::get('app_debug')){
                $map['development'] = ['neq', '1'];//开发环境才显示开发者菜单
            }
            $dataObj = Menu::where($map)->order(['order_id' => 'desc', 'id' => 'asc'])->select();
            $authList = (new \permission\Permission())->getAuthList($this->admin_id);
            foreach ($dataObj as $value){
                if( (isset($authList[$value->menu_link]) && $authList[$value->menu_link]) || empty($value->menu_link) ){
                    $menu[] = $value->toArray();
                }
            }
            $menu = list_to_child($menu);
            // 如果一二级菜单 没有子类就隐藏
            $showMenu = [];
            foreach ($menu as $key => $value) {
                $_child = [];
                foreach ($value['_child'] as $k => $v) {
                    if(!empty($v['_child'])) {
                        $_child[] = $v;
                    }
                }
                if($_child){
                    $value['_child'] = $_child;
                    $showMenu[] = $value;
                }
            }
            return $showMenu;
        });
    }
    protected function _getProType(){
        return Cache::remember('ProType',function(){
            return \app\common\model\ProductType::all(function($query){
                $query->field('id,type_name')->where('is_show', 1)->order('order_id', 'desc');
            });
        });
    }
}
