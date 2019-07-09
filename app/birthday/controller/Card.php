<?php 
namespace app\birthday\controller;
header('content-type:text/html;charset=utf8');

use \think\Controller;
use think\Db;
use think\Request;

// 生日贺卡处理控制器

class Card extends Controller
{
	// 贺卡展示页面
	public function cardview()
	{
		$request = request();

		// 页面加载数据
		$user_id = !empty($request->get("user_id")) ? $request->get('user_id') : '';
		$keyword = !empty($request->get('keyword')) ? $request->get('keyword') : '';

		// 必须传入特定参数
		if (empty($user_id) || (empty($keyword) || $keyword !== 'JLP')) {
			// 跳转金立品网站
			header("Location: http://www.jinlipin.cn"); 
			exit('跳转');
		}

		// 获取当前 user_id 对应数据信息，进行页面渲染
        $field = '*';
        $where = array('id'=> $user_id);
        $datas = get_Field_Find_One('tplay_birthday_list', $field, $where);

        if (!empty($datas)) {
        	// 当前数据流量次数加一
        	
        	// 获取当前浏览ip，
        	$ip = getIp(); 	// 124.126.3.188
        	// $ip = '124.126.3.189';

        	$visit_ip = !empty($datas['visit_ip']) ? json_decode($datas['visit_ip'], true) : '';

        	if (!empty($visit_ip)) {
        		// 校验是否已经存在
				foreach ($visit_ip as $k => $v) {
					// 遍历ip集合
					$ip_arr[] = $v['ip'];
				}

				// 获取数组键
				$key = array_search($ip, $ip_arr);

				// ip 已经存在更新最近访问时间
				if(in_array($ip, $ip_arr)) {
					$visit_ip[$key]['update_time'] = date('Y-m-d H:i:s', time());
				} else {
					// 插入数据
					$arr = array(
        				'ip' => $ip,
	        			'create_time' => date('Y-m-d H:i:s', time()),
	        			'update_time' => date('Y-m-d H:i:s', time()),
        			);
					// 追加写入
        			array_push($visit_ip, $arr);
				}

				$record = $visit_ip;
        	} else {
        		// ip记录
        		$record = array(
        			array(
        				'ip' => $ip,
	        			'create_time' => date('Y-m-d H:i:s', time()),
	        			'update_time' => date('Y-m-d H:i:s', time()),
        			),
        		);
        	}

        	$saveData = array(
        		'visit_ip' => json_encode($record),
        		'visit_num' => intval($datas['visit_num'] + 1),
        	);
        	
        	// 写入数据库
        	$where = array('id' => $user_id);
            $result = updateDatas('tplay_birthday_list', $where, $saveData);
        	
        	// dump($datas);
        	// exit;
        	
        	if (!empty($result)) {
        		// 渲染页面数据
	        	$this->assign('username', $datas['username']);
				$this->assign('producers', $datas['producers']);
				$this->assign('date', $datas['birthday_time']);
		        // 调取页面模板
		        return $this->fetch('cardview');
        	} else {
        		// 跳转金立品网站
				header("Location: http://www.jinlipin.cn"); 
				exit('跳转');
        	}
        } else {
        	// 跳转金立品网站
			header("Location: http://www.jinlipin.cn"); 
			exit('跳转');
        }
	}
}




