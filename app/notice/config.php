<?php 
return [
	'show_error_msg' => true,

	'database'    =>  [
        'type'            => 'mysql',
	    // 服务器地址
	    'hostname'        => '127.0.0.1',
	    // 数据库名
	    'database'        => 'webshop02',
	    // 用户名
	    'username'        => 'root',
	    // 密码
	    'password'        => 'root',
	    // 端口
	    'hostport'        => '3306',
	    // 连接dsn
	    'dsn'             => '',
	    // 数据库连接参数
	    'params'          => [],
	    // 数据库编码默认采用utf8
	    'charset'         => 'utf8',
	    // 数据库表前缀
	    'prefix'          => 'iwebshop_',
    ],


    // 静态文件加载
	'view_replace_str'  =>  [
	    '__JS__' => '/static/notice/js',
	    '__CSS__' => '/static/notice/css',
	    '__IMG__' => '/static/notice/images',
	    '__UPLOAD__' => '/static/upload',
	    '__FONT__' => '/static/notice/font',
	    '__MODULE__' => '/static/module',
        '__PUBLIC__'   => '/static/public',
	    '__HREF__' => 'http://'.$_SERVER['HTTP_HOST'],
	    '__ROOT__' => '/',
	],

	// 微信公众号参数
	'wx_param' => [
		'Appid' => 'wx85ca4ced0a26d973',
    	'Secret' => '96df29b96ff0d32aa7c752df3ee9b67d',
	],


	// 小程序id
	'wx_xcx_param' => [
		// 学生端
        'Appid' => 'wx382c7351c957a8d5',
        'Secret' => '80d590a579320ea60fe42d82ed31e922',

        // 教师端
        'TeacherAppid' => 'wx6e6e8fa80d99cd52',
        'TeacherSecret' => 'd5c574b33cc77e95720614301fae7056',

        // 公众号
        'GzhAppid' => 'wx85ca4ced0a26d973',
	],
	

	// 公众号微信消息通知模板
	'wx_template' => [
		// 支付模板
		'pay_template' => [
			'template_id' => 'zDMQMe1yWIgnhYvdZjRQeIzZzuesAFlSbtk_fhPOie0',
			'first' => ['value' => '您好，您的订单已经支付成功', 'color' => '#173177'],
			'remark' => ['value' => '其它信息请点击查看订单详情', 'color' => '#173177'],
		],

		// 消息通知模板
		'message_template' => [
			'template_id' => 'oeG8i-ozxhgVAj7qL4j0oXDFTTyf0UiQe4NNHdt4dMQ',
			'first' => ['value' => '收到一条通知消息', 'color' => '#ff0000'],
			'remark' => ['value' => '请尽快处理', 'color' => '#ff0000'],
		],
	],


	// 公众号消息接收人员 openid 列表,, 列表中的人员均可收到 ‘知了考证’ 公众号消息通知
	'openid_lists' => [
		// 销售列表
		'sales' => [
			'oxmtH4zc7pJ15_zJb_lihQlPt-XA',			// GOOD LUCK
			// 'oxmtH47022AeCYE1ZgOjj8LYNGcE',			// 西昂～
			// 'oxmtH4-sWubdoqFO7hMMx5uDDnN0',			// 洛琪？
			// 'oxmtH41AGViFUvgxuimTCSlZ1LSg',			// 宪照
			// 'oxmtH41O1cAoD1JQnIRNXQSrCvXg',			// 容易。
		],

	],

];
 ?>