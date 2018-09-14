<?php 
namespace app\index\controller;

use app\common\controller\IndexBase;
/**
* 单页/专题等
*/
class Topic extends IndexBase
{	
	public function index(){
		
		return $this->fetch();
	}
}