<?php

namespace app\backend\model;

use app\common\model\Base;
use think\Request;
class LogBackend extends Base
{
	protected $insert = ['request_header', 'request_method', 'request_param','create_ip'];

    protected function setRequestHeaderAttr(){
    	$header = Request::instance()->header();
        return var_export($header , true);
    }

    protected function setRequestMethodAttr(){
        return Request::instance()->method();
    }

    protected function setRequestParamAttr(){
    	$param = Request::instance()->param();
        return var_export($param , true);
    }

    protected function setCreateIpAttr(){
        return Request::instance()->ip();
    }
}
