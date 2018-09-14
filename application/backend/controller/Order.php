<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 订单控制器
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;
class Order extends Shop
{
    public function index(){        
        $dataList = \app\common\model\Order::order('id', 'desc')->paginate();
        $this->assign('dataList',$dataList);
        return $this->fetch();
    }
}