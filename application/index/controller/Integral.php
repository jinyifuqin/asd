<?php 
namespace app\index\controller;

use app\common\controller\IndexBase;
use app\common\model\Integral as Product;
use app\common\model\IntegralOrder as Order;
use app\common\logic\UserAccount as Account;
/**
* 积分商城
*/
class Integral extends IndexBase
{	
	public function index(){		
		$Integral = new Product;
	    $proList = $Integral->order(['order_id'=>'desc','id'=>'desc'])->paginate(8);	    	    
		return $this->fetch('',[
			'proList' => $proList,
			]);
	}
	public function item($id){				
		$proItem = Product::get($id);			
		$this->assign('proItem', $proItem);
		return $this->fetch();
	}

	public function exchange(){
		if(!$this->uid) $this->error('请选登录！','user/common/login');
		$proId = $this->request->has('pro_id') ? $this->request->post('pro_id/d') : die;
		$number = $this->request->post('number/d');
		if($number<1) $number = 1;
		$product = Product::get($proId);
		if(!$product) $this->error('商品不存在！');
		$data = [
			'uid' => $this->uid,
			'order_no' => date('YmdHis') . str_pad($proId, 6, "0", STR_PAD_LEFT) . str_pad($this->uid, 5, "0", STR_PAD_LEFT),
			'pro_id' => $product->id,
			'pro_name' => $product->pro_name,
			'price'  => $product->price,
			'amount' => $product->price,
			'number' => $number,
		];
		$order = new Order;
		$res = $order->data($data)->save();

		$res and $resAccount = Account::change(2002, $this->uid, -$product->price, '兑换['.$product->pro_name.']('.$product->id.')产品');

		if($res && $resAccount === true){
			$this->success('兑换成功！');
		}elseif($res){
			$order->delete();
			$this->error($resAccount);
		}else{
			$this->error('兑换失败！');
		}
	}
}