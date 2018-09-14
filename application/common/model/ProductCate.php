<?php
namespace app\common\model;
use think\Config;
use app\common\model\ProductType;
use app\common\model\ProductSpec;
use app\common\model\ProductSpecVal;
use traits\model\SoftDelete;
class ProductCate extends Base
{   
	use SoftDelete;
	protected $auto = ['parent_path'];
	public function getParentNameAttr($value, $data)
	{
		$data['parent_id']  = @$data['parent_id'] ? $data['parent_id'] : '0';
		return $this->where('id', $data['parent_id'])->value('cate_name');		
	}
	/**
	 * 产品规格
	 */
	public function getSpecValAttr($value, $data){		
		$type_id = $data['type_id'];
		$spec_id = ProductType::where('id',$type_id)->value('spec_id');
        $spec = ProductSpec::where('id','in',$spec_id)->select();
        foreach ($spec as $key => $value) {
            $value = $value->toArray();
            $value['spec_val'] = ProductSpecVal::where('spec_id',$value['id'])->column('spec_value','id');
            $spec[$key] = $value;
        }
        return $spec;
	}
}