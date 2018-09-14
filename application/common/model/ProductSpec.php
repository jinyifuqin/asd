<?php
namespace app\common\model;


class ProductSpec extends Base
{   
	public function productSpecVal()
    {
        return $this->hasMany('ProductSpecVal', 'spec_id');
    }
}