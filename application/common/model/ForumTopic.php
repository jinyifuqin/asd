<?php
namespace app\common\model;

class ForumTopic extends Base
{
    protected $auto = ['art_img', 'art_img_more'];
    public function cate()
    {
        return $this->belongsTo('Category', 'cate_id');
    }
    public function setIndustryIdAttr($value){
    	return implode($value, ',');
    }
    public function setArtImgMoreAttr($value){
        return $value ? implode($value, ',') : '';
    }

    public function getArtImgMoreArrAttr($value, $data){
        return $data['art_img_more'] ? explode(',', $data['art_img_more']) : explode(',', $data['art_img']);
    }

    public function getArtUrlAttr($value, $data){
    	return \think\Url::build('Index/detail', 'id='.$data['id']);
    }

    

    //下一篇
    public function getNextIdAttr($value, $data){
        $nextId = $this->where('order_id', 'egt',$data['order_id'])
            ->where('update_time', 'egt',$data['update_time'])
            ->where('id', 'gt',$data['id'])
            ->order(['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'])
            ->value('id');        
        return $nextId;
    }
    //下一篇
    public function getPrevIdAttr($value, $data){
        $prevId = $this->where('order_id', 'elt',$data['order_id'])
            ->where('update_time', 'elt',$data['update_time'])
            ->where('id', 'lt',$data['id'])
            ->order(['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'])
            ->value('id');        
        return $prevId;
    }
}
