<?php 
namespace app\index\controller;

use app\common\controller\IndexBase;

use app\common\model\ProductBrand;
/**
* 品牌
*/
class Brand extends IndexBase
{	
	public function index(){
		$brand = ProductBrand::order('id', 'desc')->paginate(20);
        $this->assign('brand',$brand);

		$num = range('A', 'Z');
		$this->assign('num',$num);
		return $this->fetch();
	}
	public function detail(){
		$brand_id = $this->request->param('id/d');
		$brand = ProductBrand::get($brand_id);		
	    $proList = \app\common\model\Product::where('brand_id', $brand_id)->order(['order_id'=>'desc','id'=>'desc'])->paginate(10);

		//其他保险公司
		$otherBrand = ProductBrand::order('id', 'desc')->paginate(20);

		return $this->fetch('',[
			'brand' => $brand,
			'proList' => $proList,
			'otherBrand' => $otherBrand,
			]);	
	}
}