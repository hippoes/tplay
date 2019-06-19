<?php 
namespace app\notice\controller;
header('content-type:text/html;charset=utf8');

use \think\Controller;
use common\SendMessage;
use think\Db;

class Register extends Controller
{
	public function index()
	{
		// 渲染试图层
        return $this->fetch('index');
	}

	// 问卷表单报名信息校验存储
	public function question_save()
	{
		// 表单提交参数保存
        $post = $this->request->post();

        if(!empty($_POST['question_type'])) {
        	/*// 检验规则编辑
        	$field = explode('##', trim($_POST['question_type'], '##'));
        	
        	$rules = array();
        	// 根据字段进行验证规则编写
        	foreach($field as $k=>$v) {
    			$valid = 'require';

        		if ($v == 'phone') {
        			$arr = array('question_name_0'.$k, $valid.'|max:11', '手机号码格式不正确');

        			dump($arr);
        			array_push($rules, $arr);
        		}
        	}

        	foreach($field as $k=>$v) {
        		if ($v == 'email') {
        			array_push($rules, array('question_name_0'.$k, 'require|email', '邮箱格式不正确'));
        		}
        	}

        	//验证  唯一规则： 表名，字段名，排除主键值，主键名
	        $validate = new \think\Validate($rules);
			
			//验证部分数据合法性
	        if (!$validate->check($post)) {
	        	dump($validate->getError());
	        }*/


	        // 对数据进行格式统一保存
	        
	        $validResult = true;
	        // 数据校验成功
	        if($validResult) {
	        	$data = array();
	        	foreach ($post as $k=>$v) {
	        		if(strstr($k, 'question_name')){
	        			$data[$k] = $v;
	        		}
	        	}

	        	// 插入数据保存
	        	$saveData = array(
	        		'question_id' => $post['question_source'],
	        		'answer_datas' => json_encode($data),
	        		'source' => $post['question_source'],
	        		'create_time' => date('Y-m-d H:i:s', time()),
	        		'total_time' => $post['write_time'],
	        		'ip' => getIp(),
	        	);

	        	// 写入数据表
	        	$lastId = SaveOneData('tplay_question_answer', $saveData, true);

	       		dump($saveData);
	       		dump($lastId);

	        }




        }


        



       

      
        

	}


}