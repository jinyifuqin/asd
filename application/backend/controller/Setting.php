<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 设置|全局配置
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use app\common\model\Setting as SettingModel;
use think\Config;

class Setting extends BackendBase
{
    private $group = 'basic'; //配置类型
    // 基本配置
    public function index()
    {
        if ($this->request->isPost()) {
            $this->edit();
        }
        $dataList = $this->_getSetting($this->group);
        $this->assign('dataList', $dataList);
        $this->assign('group', $this->group);
        return $this->fetch('index');
    }
    // 自定义配置
    public function custom()
    {
        $this->group = 'custom';
        return $this->index();
    }
    // 高级配置
    public function advanced()
    {
        $this->group = 'advanced';
        return $this->index();
    }

    // 通信配置
    public function notice()
    {

        $this->group = 'notice';
        $this->index();
        $subject = '欢迎您使用' . Config::get('base.app_name') . '！';
        $body    = 'Holle，我是' . Config::get('base.app_name_en') . '！' . PHP_EOL;
        $body .= '应用版本：' . Config::get('base.app_version') . PHP_EOL;
        $body .= '应用说明：' . Config::get('base.app_description') . PHP_EOL;
        $this->assign('subject', $subject);
        $this->assign('body', $body);
        // 短信余额
        $sms_account = \notice\Sms::getAccount();
        $this->assign('sms_account', $sms_account);
        return $this->fetch();
    }
    //发送邮件的
    public function mailer_send(){
        $address = $this->request->post('address');
        $subject = $this->request->post('subject');
        $body = $this->request->post('body', '', 'text_to_html');        
        $res = \notice\Smtp::send($address,$body , $subject);
        if($res === true){
            $this->success('发送成功！');
        }else{
            $this->erroe('发送失败：'.$res);
        }
    }
    // 发送短信的 (备用)
    public function sms_send(){
        $phone = $this->request->post('phone');        
        $body = $this->request->post('body');        
        $res = \notice\Sms::send($phone,$body);
        if($res === true){
            $this->success('发送成功！');
        }else{
            $this->erroe('发送失败：'.$res);
        }
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $Setting = new SettingModel;
            if ($Setting->saveEdit()) {
                $this->success('更新成功！');
            } else {
                $this->error('更新失败！');
            }
        } else {
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
        //
    }
    private function edit()
    {
        $setting  = new SettingModel;
        $postData = $this->request->post();
        $saveData = [];
        foreach ($postData as $key => $value) {
            $saveData[] = ['id' => $key, 'value' => $value];
        }
        if ($setting->saveAll($saveData)) {
            \think\Cache::rm('setting');
            $this->success('更新成功！');
        } else {
            $this->error('更新失败！');
        }
    }
}
