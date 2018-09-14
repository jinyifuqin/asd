<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 数据库
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */
namespace app\backend\controller;
use app\common\controller\BackendBase;
use think\Db;
use think\Config;
use backup\Backup;
class Database extends BackendBase
{
	public function index()
	{		
		$tables  = Db::query('SHOW table STATUS');			
		$this->assign('dataList' , $tables);
		return $this->fetch();
	}
	public function struct()
	{	
		$tableName = $this->request->param('table');
		$columns  = Db::query('SHOW FULL COLUMNS FROM ' . $tableName);
		// dump($columns);die;
		$this->assign('dataList' , $columns);
		return $this->fetch();
	}
	public function optimize(){
		$tableName = $this->request->param('table');
		$res  = Db::execute('OPTIMIZE TABLE `' . $tableName.'`');
		if($res){
			$this->success('优化成功！');
		}else{
			$this->error('优化失败！');
		}
	}
	public function repair(){
		$tableName = $this->request->param('table');
		$res  = Db::execute('REPAIR TABLE `' . $tableName.'`');
		if($res){
			$this->success('修复成功！');
		}else{
			$this->error('修复失败！');
		}
	}
	public function backup(){
		echo $this->fetch();		
		$backup = new Backup();	
		$backup->backup ($this->request->param('table'));
	}

	public function backuplist(){		
		$dataList = Backup::getBackupList();
		$this->assign('dataList', $dataList);
		return $this->fetch();		
	}
	public function restore(){
		$backup = new Backup();			
		$dataList = $backup->restore($this->request->param('url'));
	}
	public function delete(){		
		$res = Backup::deleteDir($this->request->param('id'));	
		if($res){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}
}