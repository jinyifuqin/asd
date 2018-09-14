<?php
namespace app\common\model;
use app\common\model\ProductExt;
use think\Config;
class Integral extends Base
{
    protected $auto = ['pro_img', 'pro_img_more'];
        
    public function proCate()
    {
        return $this->belongsTo('ProductCate', 'pro_cate_id');
    }
    public function brand()
    {
        return $this->belongsTo('ProductBrand', 'brand_id');
    }
    public function ext()
    {
        return $this->belongsTo('ProductExt', 'pro_id');
    }
    public function orderList(){
        return $this->hasMany('IntegralOrder','pro_id');
    }
    /**
     * 该产品规格
     */
    public function getSpecValAttr($value, $data){      
        $type_id = $this->proCate->type_id;        
        $specValue = ProductExt::where('pro_id',$data['id'])->column('spec_value');
        $specValueStr = $specValue ? implode($specValue, ',') : '';
        $spec_id = ProductType::where('id',$type_id)->value('spec_id');
        $spec = ProductSpec::where('id','in',$spec_id)->select();
        
        foreach ($spec as $key => $value) {
            $value = $value->toArray();
            $value['spec_val'] = ProductSpecVal::where('spec_id',$value['id'])->where('id','in',$specValueStr)->column('spec_value','id');
            $spec[$key] = $value;
        }
        return $spec;
    }
    /**
     * 产品状态
     */
    public function getStatusTextAttr($value, $data){
        $status = Config::get('product.status');                
        return $status[$data['status']];
    }

    public function setProImgMoreAttr($value){
        return $value ? implode($value, ',') : '';
    }

    public function getProImgMoreArrAttr($value, $data){
        return $data['pro_img_more'] ? explode(',', $data['pro_img_more']) : explode(',', $data['pro_img']);
    }

    public function getProUrlAttr($value, $data){
    	return \think\Url::build('Integral/item', 'id='.$data['id']);
    }

    // 已经选择的规格id
    public function getProSpecValueAttr($value,$data){
        $ext = ProductExt::where('pro_id',$data['id'])->column('spec_value');
        return $ext ? implode(array_unique(explode(',', implode($ext, ','))),',') : '';
    }
    // 已经选择的规格详情
    public function getProExtAttr($value,$data){
        $ext = ProductExt::where('pro_id',$data['id'])->select();
        $newExt = [];
        foreach ($ext as $key => $value) {
            $value = $value->toArray();            
            $value['spec_value_no'] = str_replace(',', '', $value['spec_value']) ;
            $newExt[$value['spec_value_no']] = $value;
        }
        return json_encode($newExt);
    }
}
