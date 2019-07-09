<?php 
namespace app\notice\controller;
header('content-type:text/html;charset=utf8');

use \think\Controller;
use common\SendMessage;
use think\Db;
use think\cache\driver\Redis;

class Test extends Controller
{
	public function index()
	{
	
		// $redisObj = new Redis();

		// $redisObj->set('JLP', '金立品');

		// dump($redisObj->get('JLP'));
	}


}