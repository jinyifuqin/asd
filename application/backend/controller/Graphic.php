<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 图文列表
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;


class Graphic extends Article
{
	protected function _myInit(){
		$this->cateModel = 3;
		$this->assign('cate_model', $this->cateModel);
	}
}