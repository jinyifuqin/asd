<?php
namespace app\common\model;
use think\Request;

class LogSms extends Base
{
    protected $insert = ['create_ip'];
    protected function setCreateIpAttr()
    {
        return Request::instance()->ip();
    }
}
