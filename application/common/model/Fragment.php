<?php
namespace app\common\model;
use word\Pinyin;
class Fragment extends Base
{   	
	public function setGuidAttr($value,$data){
		return $value ? $value : Pinyin::all($data['title']);
	}
}