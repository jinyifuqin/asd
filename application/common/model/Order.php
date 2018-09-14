<?php
namespace app\common\model;
use think\Config;
class Order extends Base
{   
	public function orderExt(){
		return $this->hasMany('OrderExt','order_id');
	}

	public function getStatusTextAttr($value, $data){
        $status = Config::get('product.order_status');
        return $status[$data['status']];
    }
}