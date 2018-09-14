<?php

namespace app\backend\model;

use app\common\model\Base;
use traits\model\SoftDelete;
class Menu extends Base
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $type = ['delete_time' => 'timestamp'];
    protected $auto = [ 'parent_path'];
}
