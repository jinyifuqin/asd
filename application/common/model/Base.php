<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 总模型
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\common\model;

use think\Config;
use think\Model;

class Base extends Model
{
    protected $request        = '';
    protected $useGlobalScope = true; // 定义全局的查询范围
    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
        $this->request = \think\Request::instance();
        if ($this->request->module() == 'backend') {
            $this->useGlobalScope = false;
        }
    }
    // 定义全局的查询范围
    protected function base($query)
    {
        if ($this->useGlobalScope && in_array('is_show', $this->db(false)->getTableInfo('', 'fields'))) {
            $query->where('is_show', 'gt', 0);
        }
    }

    public function user(){
        return $this->belongsTo('User', 'uid');
    }

    public function saveEdit()
    {
        $isUpdate = $this->request->has('id') ? $this->request->param('id') : '';
        return $this->allowField(true)->isUpdate($isUpdate)->save($this->request->post());
    }
    //父级路径
    public function setParentPathAttr($value, $data)
    {
        $data['parent_id'] = @$data['parent_id'] ? $data['parent_id'] : '0';
        $parent_path       = $this->where('id', $data['parent_id'])->value('parent_path');
        $parent_path .= $data['parent_id'] . ',';
        return $parent_path;
    }
    public function getUpdateTimeTextAttr($value, $data)
    {
        return $data['update_time'] ? date('Y-m-d H:i:s', $data['update_time']) : '--';
    }
    public function getCreateTimeTextAttr($value, $data)
    {
        return $data['create_time'] ? date('Y-m-d H:i:s', $data['create_time']) : '--';
    }
    public function getDeleteTimeTextAttr($value, $data)
    {
        return $data['delete_time'] ? date('Y-m-d H:i:s', $data['delete_time']) : '--';
    }
    public function getIsShowTextAttr($value, $data)
    {
        $status = Config::get('is_show');
        return $status[$data['is_show']];
    }
    //文字内容
    public function getContentDescAttr($value, $data)
    {
        return substr_cn($data['content'], 120);
    }
    //作者
    public function getAuthorAttr($value)
    {
        return $value ? $value : '匿名';
    }
    //标签数组
    public function getTagsArrAttr($value, $data)
    {
        return array_filter(explode(',', str_replace(['，', '|', '、', ' '], ',', $data['tags'])));
    }
    public function setTagsAttr($value)
    {
        return str_replace(['，', '|', '、', ' '], ',', $value);
    }
    public function setUpdateTimeAttr($value)
    {
        return empty($value) ? time() : strtotime($value);
    }
}
