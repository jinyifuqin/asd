<?php 
namespace app\index\controller;

use think\Db;
use think\Url;
use app\common\controller\IndexBase;
use app\common\model\Product as ProductModel;
use app\common\model\ProductCate as Cate;
use app\common\model\ProductType;
use app\common\model\ProductExt;
use app\common\model\ProductSpec;
use app\common\model\ProductSpecVal;

use app\common\model\ProductComment;
/**
* 产品
*/
class Product extends IndexBase
{	
	public function index(){
		$request = $this->request;
		// 推荐列表
		$recList = ProductModel::where('flag_rec', 'eq', 1)->limit(4)->select();
		// 保险分类
		$cateId = $request->has('id') ? $request->param('id') : 3;
		$nowCate = Cate::get($cateId);
		$cateList = Cate::where('parent_id',$cateId)->column('cate_name','id');
		if(!$cateList){
			$cateList = Cate::where('parent_id',$nowCate->parent_id)->column('cate_name','id');
		}

		// 产品规格
		$specId = ProductType::where('id',$nowCate->type_id)->value('spec_id');
		$proSpec = ProductSpec::where('id','in',$specId)->field('spec_name,id')->select();


		$spec = $request->has('spec') ? $request->param('spec') : '';
		$specArr = $spec ? explode('_', $spec) : [];

		foreach ($proSpec as $key => $value) {
			$actId = '';
			$productSpecVal = collection($value->productSpecVal)->toArray();
			$specLineAll = array_column($productSpecVal, 'id');			
			foreach ($value->productSpecVal as $k => $val) {
				$specArrLine = $specArr;
				if(!in_array($val->id, $specArr)){					
					$specArrLine = array_diff($specArrLine, $specLineAll);					
					$specArrLine[] = $val->id;
					$val->active = 0;					
				}else{
					$val->active = 1;
					$actId = $val->id;
				}
				sort($specArrLine);
				$val->url = implode($specArrLine, '_');
			}
		}		
		// 产品列表
		$product = new ProductModel;
	    

	    $param = $this->request->only('id,spec,order');
        foreach ($param as $key => $value) {
            if(is_null($value)) continue;
            switch ($key) {
                case 'id':
                    $product->where(function($query) use ($value) {                        
                        $query->where('pro_cate_id', $value)->whereOr('pro_parent_path', 'like', '%,' . $value . ',%');
                    });                    
                    break;
                case 'spec':
                    // $product->where($key, 'like', '%' . $value . '%');
                    break;
                case 'order':
                	list($by,$sc) = explode('_', $value);
                	$this->assign(['by' => $by, 'sc' => ($sc == 0 ? 1 : 0)]);
                	$sc = $sc == 1 ? 'asc' : 'desc';
                	switch ($by) {
                		case '5':
                			$product->order(['update_time'=>$sc,'order_id'=>'desc','id'=>'desc']);
                			break;
                		case '3':
                			$product->order(['price'=>$sc,'order_id'=>'desc','id'=>'desc']);
                			break;
                		case '2':
                			$product->order(['sales'=>$sc,'order_id'=>'desc','id'=>'desc']);
                			break;
                		case '1':                			
                		default:
                			$product->order(['order_id'=>'desc','id'=>'desc']);
                			break;
                	}                	
                	break;
                default:
                    $product->where($key, $value);
                    break;
            }
        }
        $proList = $product->paginate(10);

        // echo $product->getLastSql();die;
		return $this->fetch('',[
			'recList' => $recList,
			'proList' => $proList,
			'cateList' => $cateList,
			'proSpec' => $proSpec,
			]);
	}
	public function item($id){
		$proItem = ProductModel::get($id);		
		$this->assign('proItem', $proItem);
		return $this->fetch();
	}
	public function item_comment(){
		$comment = ProductComment::where('is_show', '1')->order('id','desc')->paginate(10);
		return $this->fetch('', ['comment' => $comment]);	
	}


	public function ext(){
		$proId = $this->request->post('pro_id/d');
		$specValue = str_replace('-', ',', $this->request->post('spec_value/s'));		
		$specPrice = ProductExt::getPrice($proId, $specValue);
		return ['spec_price' => $specPrice];
	}

	public function buy(){
		if(!$this->uid) $this->error('请先登录',Url::build('user/common/login'));
		$proId = $this->request->post('pro_id/d');
		$specValue = str_replace('-', ',', $this->request->post('spec_value/s'));

		$product = ProductModel::get($proId);
		// 规格名称
		$specName = ProductSpecVal::where('id','in',$specValue)->column('spec_value');
		$specName = implode($specName, ',');		
		$insertData = [
			'uid' => $this->uid,
			'pro_id' => $proId,
			'pro_name' => $product->pro_name,
			'pro_img'  => $product->pro_img,
			'spec_value' => $specValue,
			'spec_name'  => $specName,
			'spec_price' => ProductExt::getPrice($proId, $specValue),
		];
		$res = Db::name('order_tmp')->insertGetId($insertData);
		$this->success('操作成功','',['id' => $res]);
	}
}