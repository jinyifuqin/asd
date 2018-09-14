<?php
namespace app\common\model;
use think\Config;
class Link extends Base
{   
	public function getLinkTypeTextAttr($value, $data){
    	$link_type = Config::get('link_type');
		return @$link_type[$data['link_type']];
    }
    public function getLinkTargetTextAttr($value, $data){
    	$link_target = Config::get('link_target');
		return @$link_target[$data['link_target']];
    }
}