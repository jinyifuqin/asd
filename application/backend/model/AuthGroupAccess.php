<?php
/**
 * @since   2016-12-08
 * @author  TechLee
 */

namespace app\backend\model;
use app\common\model\Base;

class AuthGroupAccess extends Base {
    public function user()
	{
		return $this->belongsTo('User','uid');
	}
}