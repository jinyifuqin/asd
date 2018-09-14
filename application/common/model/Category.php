<?php
namespace app\common\model;
use think\Config;
use word\Pinyin;
use traits\model\SoftDelete;
class Category extends Base
{   
	use SoftDelete;
	protected $auto = ['parent_path'];
    /**
     * 栏目类型
     */
    public function getCateModelTextAttr($value, $data)
	{
		$status = Config::get('cate_model');
		return $status[$data['cate_model']];
	}

	public function getParentNameAttr($value, $data)
	{
		$data['parent_id']  = @$data['parent_id'] ? $data['parent_id'] : '0';
		return $this->where('id', $data['parent_id'])->value('cate_name');		
	}

	public function setGuidAttr($value,$data){
		return $value ? $value : Pinyin::all($data['cate_name']);
	}
}