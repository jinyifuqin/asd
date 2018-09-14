<?php
namespace app\common\model;


class ProductExt extends Base
{   
	public static function getPrice($proId, $specValue){
		return self::where('pro_id', $proId)->where('spec_value',$specValue)->value('spec_price');
	}
}