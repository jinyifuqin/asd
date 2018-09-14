<?php
namespace app\api\controller;
use app\common\controller\IndexBase;

use app\common\model\ConfArea;
class Conf extends IndexBase
{
	public function area()
    {  
    	$area_type = $this->request->has('area_type') ? $this->request->param('area_type') : '01';
    	$area_no = $this->request->has('area_no') ? $this->request->param('area_no') : '';
    	$where = [];
    	if(!empty($area_no)){
    		$where['area_no'] = ['like', rtrim($area_no,'0').'%'];
    	}
    	$where['area_type'] = $area_type;
    	$areaList = ConfArea::where($where)->column('area_name', 'area_no');
    	return $areaList;
    }
}