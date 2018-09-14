<?php
namespace app\common\model;

use traits\model\SoftDelete;
class Article extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $type = ['delete_time' => 'timestamp'];
    protected $auto = ['art_img', 'art_img_more', 'parent_path'];    
    public function cate()
    {
        return $this->belongsTo('Category', 'cate_id');
    }
    //父级路径
    public function setParentPathAttr($value, $data)
    {        
        $data['cate_id'] = @$data['cate_id'] ? $data['cate_id'] : '0';
        $parent_path       = $this->cate()->where('id', $data['cate_id'])->value('parent_path');
        return $parent_path;
    }
    public function setIndustryIdAttr($value){        
    	return $value ? implode($value, ',') : '';
    }
    public function setArtImgMoreAttr($value){                 
        return is_array($value) ? implode($value, ',') : $value;
    }

    public function getArtImgMoreArrAttr($value, $data){
        return $data['art_img_more'] ? explode(',', $data['art_img_more']) : explode(',', $data['art_img']);
    }

    public function getArtUrlAttr($value, $data){
    	return \think\Url::build('/news/'.$data['id']);
    }

    //作者
    public function getAuthorAttr($value){
        return $value ? $value : '匿名';
    }


    //下一篇
    public function getNextAttr($value, $data){
        $next = $this->where('order_id', 'egt',$data['order_id'])
            ->field('id,title')
            ->where('update_time', 'egt',$data['update_time'])
            ->where('id', 'neq',$data['id'])
            ->where('cate_id', 'eq',$data['cate_id'])
            ->order(['order_id' => 'asc', 'update_time' => 'asc', 'id' => 'asc'])
            ->find();
        return $next;
    }
    public function getNextIdAttr($value, $data){
        $nextId = $this->where('order_id', 'egt',$data['order_id'])
            ->where('update_time', 'egt',$data['update_time'])
            ->where('id', 'neq',$data['id'])
            ->order(['order_id' => 'asc', 'update_time' => 'asc', 'id' => 'asc'])
            ->value('id');        
        return $nextId;
    }
    //上一篇
    public function getPrevAttr($value, $data){
        $prev = $this->where('order_id', 'elt',$data['order_id'])
            ->field('id,title')
            ->where('update_time', 'elt',$data['update_time'])
            ->where('id', 'neq',$data['id'])
            ->where('cate_id', 'eq',$data['cate_id'])
            ->order(['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'])
            ->find();       
        return $prev;
    }
    public function getPrevIdAttr($value, $data){
        $prevId = $this->where('order_id', 'elt',$data['order_id'])
            ->where('update_time', 'elt',$data['update_time'])
            ->where('id', 'neq',$data['id'])
            ->where('cate_id', 'eq',$data['cate_id'])
            ->order(['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'])
            ->value('id');        
        return $prevId;
    }
}
