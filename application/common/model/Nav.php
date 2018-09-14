<?php
namespace app\common\model;
use think\Config;
use word\Pinyin;
class Nav extends Base
{   
	protected $auto = ['parent_path'];
	public function getNavTargetTextAttr($value, $data){
    	$link_target = Config::get('link_target');
		return @$link_target[$data['nav_target']];
    }
    public function setGuidAttr($value,$data){
		return $value ? $value : Pinyin::all($data['nav_name']);
	}
}