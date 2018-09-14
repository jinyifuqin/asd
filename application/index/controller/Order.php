<?php 
namespace app\index\controller;

use app\common\controller\IndexBase;
use app\common\model\Product;
use app\common\model\OrderTmp;
use app\common\model\OrderExt;

use app\common\model\InsLcappnt;
use app\common\model\InsLcinsureds;
use app\common\model\InsRisk;

/**
* 产品
*/
class Order extends IndexBase
{	
	public function confirm(){
		$orderTmpId = $this->request->param('id','','do_mdecrypt');

		$product = OrderTmp::all(['id' => $orderTmpId]);
		$order['order_price']  = '0.00';
		$order['order_amount']  = '0.00';
		foreach ($product as $key => $value) {
			$order['order_price'] += $value['spec_price'];
			$order['order_amount'] += $value['spec_price'];
		}

		$order['product'] = $product;

		$this->assign('order',$order);
		$this->assign('orderTmpId', do_mencrypt($orderTmpId));
		return $this->fetch();
	}
	public function submit(){
		$orderTmpId = $this->request->param('id','','do_mdecrypt');
		$orderNo = date('YmdHis') . str_pad($orderTmpId, 6, "0", STR_PAD_LEFT) . str_pad($this->uid, 5, "0", STR_PAD_LEFT);
		
		$product = OrderTmp::all(['id' => $orderTmpId]);	
		$order['uid']  = $this->uid;
		$order['order_no']  = $orderNo;
		$order['order_name']  = '';
		$order['order_price']  = '0.00';
		$order['order_amount']  = '0.00';
		$orderExt = [];
		foreach ($product as $key => $value) {
			$order['order_price'] += $value['spec_price'];
			$order['order_amount'] += $value['spec_price'];
			$order['order_name']  .= $value['pro_name'];
			$orderExt[] = [
				'pro_id' => $value['pro_id'],
				'uid' => $this->uid,
				'pro_name' => $value['pro_name'],
				'pro_img' => $value['pro_img'],
				'spec_value' => $value['spec_value'],
				'spec_name' => $value['spec_name'],
				'spec_price' => $value['spec_price'],
			];
		}
		$orderModel = new \app\common\model\Order;
		$res = $orderModel->data($order)->save();
		$orderId = $orderModel->id;
		$orderExt = array_map(function($val) use ($orderId){
			$val['order_id'] = $orderId;
			return $val;
		}, $orderExt);
		$orderExtModel = new OrderExt;
		$res = $orderExtModel->saveAll($orderExt);
		if($res){
			InsLcappnt::where('order_tmp_id', $orderTmpId)->setField('order_id', $orderId);
			InsLcinsureds::where('order_tmp_id', $orderTmpId)->setField('order_id', $orderId);
			$this->success('订单提交成功！','User/index/index');
		}
	}

	public function step1(){
		$orderTmpId = $this->request->post('id/d');		
		$this->assign('orderTmpId', do_mencrypt($orderTmpId));
		return $this->fetch();	
	}
	public function step2(){
		$orderTmpId = $this->request->param('id','','do_mdecrypt');

		$map           = ['order_tmp_id' => $orderTmpId];
        $InsLcappnt    = InsLcappnt::get($map); //投保人信息
        $InsLcinsureds = InsLcinsureds::get($map); //被保人信息
		$this->assign('InsLcappnt', $InsLcappnt);		
		$this->assign('InsLcinsureds', $InsLcinsureds);		

		$this->assign('orderTmpId', do_mencrypt($orderTmpId));
		return $this->fetch();	
	}
	public function lcappnt(){		
		$order_tmp_id = $this->request->post('order_tmp_id','','do_mdecrypt');
		$hasInsLcappnt = InsLcappnt::get(['order_tmp_id' => $order_tmp_id]);
		
		$insLcappnt = new InsLcappnt();

		if($hasInsLcappnt){
			$insLcappnt->isUpdate(true)->where(['order_tmp_id' => $order_tmp_id]);
		}
		$insLcappnt->data($this->request->post(),true);
		$insLcappnt->order_tmp_id = $order_tmp_id;
		$res = $insLcappnt->allowField(true)->save();
		if($res){
			//保存险种信息
			$risk = new InsRisk;
			$data = [
				'lcappnt_id' => $insLcappnt->id,
				'riskcode' => '',
				'mainriskcode' => '',
				'amnt' => '',
				'prem' => '',

				// 'mult' => '',
				// 'payintv' => '',
				// 'insuyearflag' => '',
				// 'insuyear' => '',
				// 'payendyearflag' => '',
				// 'payendyear' => '',
				// 'rnewflag' => '',
			];
			$hasRisk = InsRisk::get(['lcappnt_id' => $insLcappnt->id]);
			if($hasRisk){
				$risk->isUpdate(true)->where(['lcappnt_id' => $insLcappnt->id]);
			}
			$res = $risk->data($data, true)->allowField(true)->save();
			if($res){
				$this->success('保存成功！');
			}
		}
		$this->success('保存失败！');
		
	}
	public function lcinsureds(){	
		$order_tmp_id = $this->request->post('order_tmp_id','','do_mdecrypt');
		$hasInsLcappnt = InsLcinsureds::get(['order_tmp_id' => $order_tmp_id]);
		
		$insLcappnt = new InsLcinsureds();

		if($hasInsLcappnt){
			$insLcappnt->isUpdate(true)->where(['order_tmp_id' => $order_tmp_id]);
		}
		$insLcappnt->data($this->request->post(),true);
		$insLcappnt->order_tmp_id = $order_tmp_id;
		$res = $insLcappnt->allowField(true)->save();		
		if($res){
			$this->success('保存成功！');
		}else{
			$this->success('保存失败！');
		}
	}
	
}