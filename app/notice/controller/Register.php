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
	    $this->redirect('question_form');

		// 渲染试图层
        return $this->fetch('index');
	}

	// 问卷表单
	public function question_form()
	{
		// 跳转表单页面
		$post = $this->request->param();
		if(!empty($post) && $post['question_form']) {
            // ACCA学前评估 页面
			if($post['question_form'] == 'acca') {
                // 获取 表单对应title
	            $datas = get_Field_Find_One('tplay_question', '*', array('id'=> 1));
	            $question = array(
	            	'id' => $datas['id'],
	            	'question_title' => $datas['question_title'],
	            );

	            $this->assign('question', $question);
				return $this->fetch('acca');

			} else if ($post['question_form'] == 'accalq') {
                // ACCA学前评估 页面 页面
				$datas = get_Field_Find_One('tplay_question', '*', array('id'=> 2));
	            $question = array(
	            	'id' => $datas['id'],
	            	'question_title' => $datas['question_title'],
	            );

	            $this->assign('question', $question);
				return $this->fetch('accalq');

			} else if ($post['question_form'] == 'cma') {
                // 管理会计师CMA报考条件快速测试通道 页面
				$datas = get_Field_Find_One('tplay_question', '*', array('id'=> 3));
	            $question = array(
	            	'id' => $datas['id'],
	            	'question_title' => $datas['question_title'],
	            );

	            $this->assign('question', $question);
				return $this->fetch('cma');
            } else if ($post['question_form'] == 'success') {

			    if(!empty($post['question_id']) && $post['question_id'] == '2') {
			        $return = true;
                } else {
                    $return = false;
                }

                $this->assign('return', $return);
                return $this->fetch('success');
			}
		} else {
		    // 默认访问 ACCA学前评估 页面
            $datas = get_Field_Find_One('tplay_question', '*', array('id'=> 1));
            $question = array(
                'id' => $datas['id'],
                'question_title' => $datas['question_title'],
            );

            $this->assign('question', $question);
            return $this->fetch('acca');
		}
	}


	// 问卷表单报名信息校验存储
	public function question_save()
	{
		// 表单提交参数保存
        $post = $this->request->post();

        // 校验必须参数
        if (!empty($post) && !empty($post['question_source']) && !empty($post['question_id'])) {
            $id = str_replace('question_0', '', $post['question_id']);
            $question = Db::table('tplay_question')
                ->field('question_config')
                ->where(array('id' => $id))
                ->find();
            $question_config = json_decode($question['question_config'], true);
            foreach ($question_config as $k=>$v) {
                $rules['question_name_0'.($k+1)] = 'require';
                $msg['question_name_0'.($k+1)] = $v['title'].'不能为空';
            }

            // 来源 数据判断是否含有 手机号码，邮箱地址进行验证
            if ($post['question_id'] == 'question_01') {
                $phone = $post['question_name_04'];
                $email = $post['question_name_05'];
                $username = $post['question_name_03'];

                $rules['question_name_04'] = 'require|max:11';
                $rules['question_name_05'] = 'require|email';
                $msg['question_name_04'] = '手机号码不能为空或者不能超过11位';
                $msg['question_name_05'] = '邮箱地址不能为空或者邮箱格式错误';
            } else if ($post['question_id'] == 'question_02') {
                $phone = $post['question_name_02'];
                $email = $post['question_name_03'];
                $username = $post['question_name_01'];

                $rules['question_name_02'] = 'require|max:11';
                $rules['question_name_03'] = 'require|email';
                $msg['question_name_02'] = '手机号码不能为空或者不能超过11位';
                $msg['question_name_03'] = '邮箱地址不能为空或者邮箱格式错误';
            } else if ($post['question_id'] == 'question_03') {
                $phone = $post['question_name_05'];
                $email = $post['question_name_06'];
                $username = $post['question_name_03'];

                $rules['question_name_05'] = 'require|max:11';
                $rules['question_name_06'] = 'require|email';
                $msg['question_name_05'] = '手机号码不能为空或者不能超过11位';
                $msg['question_name_06'] = '邮箱地址不能为空或者邮箱格式错误';

                unset($rules['question_name_04']);
                unset($msg['question_name_04']);
            }



            // 检验规则
            $validate = new \think\Validate($rules, $msg);

            //验证部分数据合法性
            if (!$validate->check($post)) {
                $returnDatas['errorcode'] = '30008';
                $returnDatas['message'] = $validate->getError();
                return json_encode($returnDatas);
            }

        	// 计算消耗时间
        	$total_time = time() - $post['init_timestamp'];

        	// 表单填写内容转数组
        	foreach ($post as $key=>$value) {
                if(strstr($key, 'question_name')) {
                    $answer_datas[$key] = $value;
                }
            }

        	// 插入数据保存
        	$saveData = array(
        		'question_id' => $post['question_id'],
        		'answer_datas' => json_encode($answer_datas),
        		'source' => $post['question_source'],
        		'create_time' => date('Y-m-d H:i:s', time()),
        		'total_time' => $total_time,
        		'ip' => getIp(),
        		'equipment' => $post['equipment'],
        	);

        	// 写入数据表
        	$lastId = SaveOneData('tplay_question_answer', $saveData, true);

            // 报名成功发送消息通知到销售
            $source = $post['question_source'];
            $obj = new Message();
            $obj->send($source, $username, $phone, $email);

       		$returnDatas['errorcode'] = !empty($lastId) ? '0' : '30008';        // 30008 添加失败
            $returnDatas['message'] = !empty($lastId) ? '添加成功' : '添加失败';
            return json_encode($returnDatas);
        } else {
            $returnDatas['errorcode'] = '30008';        // 30008 添加失败
            $returnDatas['message'] = '数据信息错误';
            return json_encode($returnDatas);
        }
	}


}