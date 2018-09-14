<?php
namespace app\common\model;


class ProductType extends Base
{   
	public function setSpecIdAttr($value){        		
    	return $value ? implode($value, ',') : '';
    }

    public function setBrandIdAttr($value){        		
    	return $value ? implode($value, ',') : '';
    }

    public function getSpecIdArrAttr($value, $data){
        return $data['spec_id'] ? explode(',', $data['spec_id']) : [];
    }

    public function getBrandIdArrAttr($value, $data){
        return $data['brand_id'] ? explode(',', $data['brand_id']) : [];
    }

}