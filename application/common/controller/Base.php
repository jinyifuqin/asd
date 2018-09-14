<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 系统全局控制器
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\common\controller;
use think\Controller;
use think\Session;
use think\Config;
use think\Cache;
use app\common\model\User;
class Base extends Controller
{
    protected $uid = '';
    protected $userInfo = null;
    //空操作
    public function _empty($name = '')
    {
        return $this->fetch();
    }
    /**
     * 初始化系统
     */
    protected function _initialize()
    {
        $this->_setConfig();//读取数据库配置，动态配置到系统中
        $this->_checkWebStatus();//检测网站开关
        $this->_checkLoginStatus();//检查登录状态
        //模板常量
        $static_path = Config::get('view_replace_str.__STATIC__');
        $tmp_var     = [
            'static_path'  => $static_path, //static目录
            'common_path'  => $static_path . 'common',// common模块资源路径            
            'default_path' => $static_path . strtolower(Config::get('default_module')),// 默认模块资源路径            
            'style_path'   => $static_path . $this->request->module(),// 当前模块资源路径
        ];
        $this->assign($tmp_var);        
    }
    //检查登录状态
    private function _checkLoginStatus(){
        $this->uid = Session::get('uid');
        $userInfo  = User::get($this->uid);        
        if(!$userInfo){            
            $this->uid = '';
        }else{
            $this->userInfo = $userInfo;
        }
    }
    //检测网站开关
    private function _checkWebStatus(){
        $webStatus = Config::get('setting.web_status');
        $webStatusCn = Config::get('setting.web_status_cn');
        if(!$webStatus && $this->request->module() != 'backend'){
            exit(text_to_html($webStatusCn));
        }        
    }
    /**
     * 读取数据库配置，动态配置到系统中
     */
    private function _setConfig()
    {
        //读取全局配置
        $setting  = $this->_getSetting();
        $confData = [];
        foreach ($setting as $key => $value) {
            $config_key = $value->key;
            $config_value = $value->value;
            if(!empty($value->parent)){
                $config = Config::get($value->parent);
                $config[$value->key] = $value->value;
                $config_key = $value->parent;
                $config_value = $config;           
            }
            if($value->replace == 1){
                Config::set($config_key, $config_value);
            }else{
                $confData[$config_key] = $config_value;
            }
        }
        Config::set(['setting' => $confData]);
        $this->assign('setting', $confData);
    }
    /**
     * 获取后台配置，并缓存
     */
    protected function _getSetting($group = 'all')
    {
        $result = Cache::remember('setting', function () {
            $setting = \app\common\model\Setting::all(function ($query) {
                $query->field('order_id,create_time,update_time',true)->order('order_id', 'desc')->order('id', 'asc');
            });
            $resultGroup = [];
            $resultGroup['all'] = [];
            foreach ($setting as $key => $value) {
                $resultGroup['all'][] = $value;
                $resultGroup[$value->group][] = $value;
            }        
            return $resultGroup;             
        });
        return  isset($result[$group]) ? $result[$group] : [];
    }
    protected function _getCateTree()
    {
        $result = Cache::remember('cateTree', function () {
            $Category = \app\common\model\Category::all(function ($query) {
                $query->order('order_id', 'desc');
            });
            return list_to_tree($Category);
        });
        return $result;
    }
    protected function _getCateChild($parent_id = 0)
    {
        $Category = \app\common\model\Category::all(function ($query) use ($parent_id) {
            $query->field('id,cate_name,parent_id')->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%' . $parent_id . ',%')->order('order_id', 'desc');
        });
        return list_to_child($Category, $parent_id);
    }
    protected function _getIndustryTree()
    {
        $result = Cache::remember('industryTree', function () {
            $industry = \app\common\model\Industry::all(function ($query) {
                $query->order('order_id', 'desc');
            });
            return list_to_tree($industry);
        });
        return $result;
    }
    protected function _getIndustryChild()
    {
        $industry = \app\common\model\Industry::all(function ($query) {
            $query->field('id,industry_name,parent_id')->order('order_id', 'desc');
        });
        return list_to_child($industry);
    }
    protected function _getNavTree($parent_id = '0')
    {
        $result = Cache::remember('navTree' . $parent_id, function () use ($parent_id) {
            $result = \app\common\model\Nav::all(function ($query) use ($parent_id) {
                $query->order('order_id', 'desc');
                if ($parent_id > 0) {
                    $query->where('parent_id', $parent_id);
                }
            });
            return list_to_tree($result, $parent_id);
        });
        return $result;
    }
    protected function _getNavChild($parent_id = '0')
    {
        $result = Cache::remember('navChild' . $parent_id, function () use ($parent_id) {
            $result = \app\common\model\Nav::all(function ($query) use ($parent_id) {
                $query->order('order_id', 'desc');
                if ($parent_id > 0) {
                    $query->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%' . $parent_id . '%');
                }
            });
            return list_to_child($result, $parent_id);
        });
        return $result;
    }
    protected function _getProCateTree()
    {
        $result = Cache::remember('proCateTree', function () {
            $Category = \app\common\model\ProductCate::all(function ($query) {
                $query->order('order_id', 'desc');
            });
            return list_to_tree($Category);
        });
        return $result;
    }
    protected function _getProCateChild($parent_id = 0)
    {
        $Category = \app\common\model\ProductCate::all(function ($query) use ($parent_id) {
            $query->field('id,cate_name,parent_id')->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%' . $parent_id . ',%')->order('order_id', 'desc');
        });
        return list_to_child($Category, $parent_id);
    }
    protected function _getProBrand()
    {
        $result = Cache::remember('proBrand', function () {
            $Category = \app\common\model\ProductBrand::all(function ($query) {
                $query->order('order_id', 'desc');
            });
            return list_to_tree($Category);
        });
        return $result;
    }
}
