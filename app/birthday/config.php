<?php 
return [
	'show_error_msg' => true,

    // 静态文件加载
	'view_replace_str'  =>  [
	    '__UPLOAD__' => '/static/upload',
	    '__MODULE__' => '/static/module',
        '__BIRTHDAY__'   => '/static/birthday',
	    '__HREF__' => 'http://'.$_SERVER['HTTP_HOST'],
	    '__ROOT__' => '/',
	],

	
];
 ?>