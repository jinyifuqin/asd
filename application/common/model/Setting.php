<?php
namespace app\common\model;

class Setting extends Base
{
	protected $insert = ['group'];
	public function getDescAttr($value, $data){
        return '（'.$data['key'] .'）'. $value;
    }

    public function setGroupAttr($value){
    	return 'custom';
    }
}
