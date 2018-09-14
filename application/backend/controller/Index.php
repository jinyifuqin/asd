<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 后台首页
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use app\backend\model\Menu;
use think\Cache;
use think\Config;
use think\Db;
class Index extends BackendBase
{
    public function index()
    {
        $dataList = $this->_getMenuChild();
        $this->assign('dataList', $dataList);
        $this->assign('nickname', $this->adminInfo['nickname'] ? $this->adminInfo['nickname'] : $this->adminInfo['admin_name']);
        return $this->fetch();
    }
    public function dashboard(){
        $this->assign('avatar', $this->adminInfo->avatar);
        $this->assign('nickname', $this->adminInfo['nickname'] ? $this->adminInfo['nickname'] : $this->adminInfo['admin_name']);
        $this->assign('login_times', $this->adminInfo->login_times);
        $this->assign('login_time', $this->adminInfo->login_time_text);
        $this->assign('app_name', Config::get('base.app_name'));        
        $this->assign('app_version', Config::get('base.app_version'));
        $this->assign('app_description', Config::get('base.app_description'));
        $this->assign('app_debug', Config::get('APP_DEBUG'));

        // 站点统计
        $siteCount = Cache::remember('siteCount',function(){
            $siteCount['admin'] = \app\backend\model\Admin::count('id');
            $siteCount['category'] = \app\common\model\Category::count('id');
            $siteCount['article'] = \app\common\model\Article::count('id');
            $siteCount['link'] = \app\common\model\Link::count('id');
            $siteCount['ad'] = \app\common\model\Ad::count('id');
            $siteCount['message'] = \app\common\model\Message::count('id');
            $siteCount['log'] = \app\backend\model\LogBackend::count('id');
            $tables = Db::getTables();
            $siteCount['db'] = count($tables);
            return $siteCount;
        });
        $tables = Db::getTables();
        $this->assign('siteCount', $siteCount);

        $serverInfo = Cache::remember('serverInfo',function(){
            $db_version = Db::query('select version() as version');
            return [
                'os' => PHP_OS,
                'server_software' => $this->request->server('SERVER_SOFTWARE'),
                'program_version' => 'PHP '.PHP_VERSION,
                'db_version' => 'Mysql '.@$db_version[0]['version'],                
            ];
        });
        $serverInfo['http_user_agent'] = $this->request->header('user-agent');
        $serverInfo['date'] = date('Y年m月d日 H时i分');
        $serverInfo['app_support'] = Config::get('base.app_support');
        $serverInfo['app_support_site'] = Config::get('base.app_support_site');
        $this->assign('serverInfo', $serverInfo);
        return $this->fetch();
    }

    public function clear(){
        // 清除模板缓存、日志文件及其子目录
        $path  = RUNTIME_PATH;        
        $this->unlinkDir($path);
        //清除缓存
        Cache::clear();
        //保持登录状态
        // Cache::set($this->admin_id, session_id(), Config::get('online_time'));
        return ['status' => 1];
    }
    private function unlinkDir($path){
        $files = scandir($path);
        if ($files) {
            foreach ($files as $file) {                    
                if ('.' != $file && '..' != $file && is_dir($path . $file)) {
                    array_map('unlink', glob($path . $file . '/*.*'));
                    $this->unlinkDir($path . $file . DS);
                } elseif (is_file($path . $file)) {                    
                    unlink($path . $file);
                }
            }
        }
    }
}
