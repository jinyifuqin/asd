<?php
namespace app\common\logic;

use app\common\model\Base;
use app\common\model\UserAccountLog;

class UserAccount extends Base
{   

	public static function change($logType, $uid, $affect, $desc = ''){
		$account = self::get(['uid' => $uid]);
		if(!$account){
			$account = new UserAccount;
			$account->id = $uid;
			$account->uid = $uid;
			$account->save();
			$account = self::get($account->id);
		}
		switch ($logType) {
			case '2001':
			case '2002':
				$account->integral = bcadd($account->integral, $affect, 0);
				break;

			case '1001':
			case '1002':				
			default:
				$account->available = bcadd($account->available, $affect, 2);
				break;
		}
		if($account->integral < 0) return '积分不足！';
		if($account->available < 0) return '可用余额不足！';
		$accountLog = new UserAccountLog;
		$accountLog->uid = $uid;
		$accountLog->log_type = $logType;
		$accountLog->affect = $affect;
		$accountLog->available = $account->available;
		$accountLog->freeze = $account->freeze;
		$accountLog->integral = $account->integral;
		$accountLog->desc = $desc;
		if($resLog = $accountLog->save() && $res = $account->save()){
			 return true;
		}elseif ($resLog) {
			$accountLog->delete();
			return $accountLog->getError();
		}else{
			return $account->getError();
		}

	}	
}