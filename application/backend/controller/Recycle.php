<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 回收站
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;

use app\common\controller\BackendBase;
use app\common\model\Article;
use app\common\model\Category;

class Recycle extends BackendBase
{

	public function _empty($name = '')
	{		
		$nameArr = explode('_', $name);
		$id = $this->request->has('id') ? $this->request->param('id') : '';
		$res = false;
		$modelName = '\\app\\common\\model\\'.ucfirst($nameArr[1]);		
		class_exists($modelName) || die;
		$model = new $modelName;
		$model->id = $id;
		switch ($nameArr[0]) {
			//恢复
			case 'restore':
				$res = $model->restore();
				break;
			case 'delete':
				$res = $model->delete(true);
				break;
			case 'empty':
			 	$res = $model->onlyTrashed()->delete(true);				
				break;
		}
		if($res){
            $this->success('操作成功！');
        }else{
            $this->error('操作失败！');
        }
	}
    public function article(){        
        $dataList = Article::onlyTrashed()->order('id', 'desc')->paginate();        
        $this->assign('dataList',$dataList);
        return $this->fetch();
    }
    public function category(){        
        $dataList = Category::onlyTrashed()->order('id', 'desc')->paginate();        
        $this->assign('dataList',$dataList);
        return $this->fetch();
    }
}