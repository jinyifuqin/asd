<?php
namespace app\common\model;
use think\Config;
use word\Pinyin;
class Ad extends Base
{   	
	public function getAdTypeTextAttr($value, $data){
    	$ad_type = Config::get('ad_type');
		return @$ad_type[$data['ad_type']];
    }
    public function setGuidAttr($value,$data){
		return $value ? $value : Pinyin::all($data['ad_name']);
	}
}