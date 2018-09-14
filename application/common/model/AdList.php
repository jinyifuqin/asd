<?php
namespace app\common\model;
use think\Config;
class AdList extends Base
{   
	public function ad()
    {
        return $this->belongsTo('Ad', 'ad_id');
    }
}