<?php
namespace app\notice\controller;
header('content-type:text/html;charset=utf8');

use \think\Controller;
use common\SendMessage;
use think\Db;

class Message extends Controller
{

    public function send()
    {
        $form = !empty($_GET['form']) ? $_GET['form'] : '金立品CMA--快速评估';                 // 来源
        $username = !empty($_GET['username']) ? $_GET['username'] : '冯帅';     // 昵称
        $phone = !empty($_GET['phone']) ? $_GET['phone'] : '17610900163';              // 联系方式
        $email = !empty($_GET['email']) ? $_GET['email'] : '2929006594@qq.com';              // 联系邮箱


        // $form = '金立品CMA--快速评估';
        // $form = '金立品ACCA--福利福利';
        // $form = '金立品ACCA--ACCA礼包';
        // $form = '金立品网络教育--学前评估';
        $form = '金立品网络教育--学习资料';
        $username = '测试学员';
        $phone = '17610900000';
        $email = '2929000000@qq.com';

        // 通知消息内容拼接
        $str = '';
        if (!empty($username)) {
            $str .= ' 姓名：'.$username.'
                   ';
        }
        if (!empty($phone)) {
            $str .= '联系方式：'.$phone.'
                   ';
        }
        if (!empty($email)) {
            $str .= '联系邮箱：'.$email.'
                   ';
        }
        if (!empty($form)) {
            $str .= '来源：'.$form;
        }

        // 销售人员openid
        $sales_openids = config('openid_lists.sales');

        // 实例化消息模板
        $sendObj = new SendMessage();

// ------------------------------ 发送公众号消息模板内容  ------------------------------
        $mp_template = config('wx_template.message_template');

        // 跳转链接地址
        $jump_urls = '';
        // 小程序跳转地址
        $pagepaths = '';

        // 填充待发送消息数据模板
        $mpDatas = array(
            'keyword1' => array( 'value' => date('Y-m-d H:i:s', time()), 'color' => '#0000ff'),
            'keyword2' => array( 'value' => $str, 'color' => '#0000ff'),
            'keyword3' => array(  'value' => '下发通知成功', 'color' => '#0000ff'),
        );

        // 发送消息内容排版
        $data['first'] = $mp_template['first'];
        foreach ($mpDatas as $k=>$v) {
            $data[$k] = $v;
        }
        $data['remark'] = $mp_template['remark'];

        // ------------------------------ 公众号消息模板 ------------------------------
        $mp_template_msg = array(
            'appid' => config('wx_param.Appid'),                // 公众号appid
            'template_id' => $mp_template['template_id'],       // 模板id
            'url' => $jump_urls,                                // 跳转链接地址
            'miniprogram' => array(
                'appid' => '',                                  // 小程序appid
                'pagepath' => $pagepaths                        // 跳转小程序页面
            ),  
            'data' => $data,
        );

        foreach ($sales_openids as $k => $v) {
            $sendResult = $sendObj->InitSendTemplate($v, $mp_template_msg, '', '');
            if($sendResult == 'ok') {
                dump('发送成功:'.$v);
            } else {
                dump('发送失败:'.$sendResult.' , openid:'.$v);
            }
        }
    }







    // 发送微信消息方法
	public function send_wx_message()
	{
		$page = !empty($_GET['pageindex']) ? $_GET['pageindex'] : '1';
		$count = !empty($_GET['pagecount']) ? $_GET['pagecount'] : '10';
		

		// 实例化消息模板
		$sendObj = new SendMessage();

        // $access_token = $sendObj->get_access_token();
        
        // ------------------------------ 接收用户 ------------------------------
		$touser = 'oxmtH4zc7pJ15_zJb_lihQlPt-XA'; 	// GOOD LUCK

		// ------------------------------ 发送公众号消息模板内容  ------------------------------
		$mp_template = config('wx_template.pay_template');

		// 跳转链接地址
        $jump_urls = '';
        // 小程序跳转地址
        $pagepaths = '';

        // 填充待发送消息数据模板
        $mpDatas = array(
        	'keyword1' => array( 'value' => '知了ACCA金币充值', 'color' => '#173177'),
            'keyword2' => array( 'value' => '微信支付', 'color' => '#173177'),
            'keyword3' => array(  'value' => '450元', 'color' => '#173177'),
        );

        // 发送消息内容排版
        $data['first'] = $mp_template['first'];
        foreach ($mpDatas as $k=>$v) {
        	$data[$k] = $v;
        }
        $data['remark'] = $mp_template['remark'];

		// ------------------------------ 公众号消息模板 ------------------------------
		$mp_template_msg = array(
			'appid' => config('wx_param.Appid'),				// 公众号appid
			'template_id' => $mp_template['template_id'],		// 模板id
			'url' => $jump_urls,								// 跳转链接地址
			'miniprogram' => array(
				'appid' => '',									// 小程序appid
				'pagepath' => $pagepaths						// 跳转小程序页面
			),	
			'data' => $data,
		);


		// ------------------------------ 小程序消息模板 ------------------------------
		$weapp_template = config('wx_xcx_template.student');

		$get_formid_url = 'https://wx.jinlipin.cn/index.php?controller=acca_comment&action=get_formid&openid='.$touser;

		// 获取formid
        $formid = json_decode(file_get_contents($get_formid_url), true);

        // dump($formid);
        // exit;

        if ($formid['result']['errorcode'] !== '0') {
        	// 不存在有效的 formid
            $weapp_template_msg = array();
        } else {
        	$formid = $formid['result']['datas'];

        	// 存在formid 进行模板消息排版发送
            $xcx_page = '';                                 //跳转页面
            $xcx_datas = array(
                'keyword1' => array('value' => 'dingdanhao123456789'),
                'keyword2' => array('value' => date('Y年m月d日')),
                'keyword3' => array('value' => date('Y-m-d H:i:s')),
                'keyword4' => array('value' => '450元'),
                'keyword5' => array('value' => '已受理'),
                'keyword6' => array('value' => '知了ACCA金币充值'),
                'keyword7' => array('value' => '其它信息请点击订单查看详情'),
            );

            // 重点放大关键字
            $emphasis = array(

            );

            // 整合小程序服务通知消息
            $weapp_template_msg = array(
                'template_id' => $weapp_template['pay_template'],         // 模板id
                'page' => $xcx_page,                        // 跳转页面
                'form_id' => $formid,                       // formid
                'data' => $xcx_datas,                       // 发送消息模板内容
                'emphasis_keyword' => $emphasis,            // 重点放大关键字
            );
        }

		$path = '';

		$sendResult = $sendObj->InitSendTemplate($touser, $mp_template_msg, $weapp_template_msg, $path);

		dump($sendResult);
	}





}
