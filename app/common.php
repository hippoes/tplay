<?php
// +----------------------------------------------------------------------
// | Tplay [ WE ONLY DO WHAT IS NECESSARY ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://tplay.pengyichen.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 根据附件表的id返回url地址
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function geturl($id)
{
	if ($id) {
		$geturl = \think\Db::name("attachment")->where(['id' => $id])->find();
		if($geturl['status'] == 1) {
			//审核通过
			return $geturl['filepath'];
		} elseif($geturl['status'] == 0) {
			//待审核
			return '/uploads/xitong/beiyong1.jpg';
		} else {
			//不通过
			return '/uploads/xitong/beiyong2.jpg';
		} 
    }
    return false;
}


/**
 * [SendMail 邮件发送]
 * @param [type] $address  [description]
 * @param [type] $title    [description]
 * @param [type] $message  [description]
 * @param [type] $from     [description]
 * @param [type] $fromname [description]
 * @param [type] $smtp     [description]
 * @param [type] $username [description]
 * @param [type] $password [description]
 */
function SendMail($address)
{
    vendor('phpmailer.PHPMailerAutoload');
    //vendor('PHPMailer.class#PHPMailer');
    $mail = new \PHPMailer();          
     // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();                
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';         
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address); 

    $data = \think\Db::name('emailconfig')->where('email','email')->find();
            $title = $data['title'];
            $message = $data['content'];
            $from = $data['from_email'];
            $fromname = $data['from_name'];
            $smtp = $data['smtp'];
            $username = $data['username'];
            $password = $data['password'];   
    // 设置邮件正文
    $mail->Body=$message;           
    // 设置邮件头的From字段。
    $mail->From=$from;  
    // 设置发件人名字
    $mail->FromName=$fromname;  
    // 设置邮件标题
    $mail->Subject=$title;          
    // 设置SMTP服务器。
    $mail->Host=$smtp;
    // 设置为"需要验证" ThinkPHP 的config方法读取配置文件
    $mail->SMTPAuth=true;
    //设置html发送格式
    $mail->isHTML(true);           
    // 设置用户名和密码。
    $mail->Username=$username;
    $mail->Password=$password; 
    // 发送邮件。
    return($mail->Send());
}


/**
 * 阿里大鱼短信发送
 * @param [type] $appkey    [description]
 * @param [type] $secretKey [description]
 * @param [type] $type      [description]
 * @param [type] $name      [description]
 * @param [type] $param     [description]
 * @param [type] $phone     [description]
 * @param [type] $code      [description]
 * @param [type] $data      [description]
 */
function SendSms($param,$phone)
{
    // 配置信息
    import('dayu.top.TopClient');
    import('dayu.top.TopLogger');
    import('dayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
    import('dayu.top.ResultSet');
    import('dayu.top.RequestCheckUtil');

    //获取短信配置
    $data = \think\Db::name('smsconfig')->where('sms','sms')->find();
            $appkey = $data['appkey'];
            $secretkey = $data['secretkey'];
            $type = $data['type'];
            $name = $data['name'];
            $code = $data['code'];
    
    $c = new \TopClient();
    $c ->appkey = $appkey;
    $c ->secretKey = $secretkey;
    
    $req = new \AlibabaAliqinFcSmsNumSendRequest();
    //公共回传参数，在“消息返回”中会透传回该参数。非必须
    $req ->setExtend("");
    //短信类型，传入值请填写normal
    $req ->setSmsType($type);
    //短信签名，传入的短信签名必须是在阿里大于“管理中心-验证码/短信通知/推广短信-配置短信签名”中的可用签名。
    $req ->setSmsFreeSignName($name);
    //短信模板变量，传参规则{"key":"value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开。
    $req ->setSmsParam($param);
    //短信接收号码。支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，一次调用最多传入200个号码。
    $req ->setRecNum($phone);
    //短信模板ID，传入的模板必须是在阿里大于“管理中心-短信模板管理”中的可用模板。
    $req ->setSmsTemplateCode($code);
    //发送
    

    $resp = $c ->execute($req);
}


function SendAliSms($param, $phone) 
{
    // 配置信息
    import('sms.SmsDemo');

    $sms = new \SmsDemo();

    $sms->SetConfig($phone, $param);

    $res = $sms->sendSms();
    
    return  $res;
}


/**
 * 替换手机号码中间四位数字
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function hide_phone($str){
    $resstr = substr_replace($str,'****',3,4);  
    return $resstr;  
}

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */
function showMsg($status,$message = '',$data = array()){
    $result = array(
        'errorcode' => $status,
        'message' =>$message,
        'data' =>$data
    );
    exit(json_encode($result));
}
/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }
    return (object)$arr;
}
/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
    return $obj;
}
/**
 * PHP截取字符串长度
 * @param  [type]  $string [ 待处理字符串 ]
 * @param  [type]  $sublen [ 截取长度 ]
 * @param  integer $start [ 开始位置 默认为 0]
 * @param  string $code [ 字符编码 Utf-8,gb2312 默认为Utf-8 ]
 * @return [type]          [ 处理后的字串 ]
 */
function cutStr($string, $sublen, $start = 0, $code = 'UTF-8')
{
    if ($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        if (count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)) . "...";
        return join('', array_slice($t_string[0], $start, $sublen));
    } else {
        $start = $start * 2;
        $sublen = $sublen * 2;
        $strlen = strlen($string);
        $tmpstr = '';
        for ($i = 0; $i < $strlen; $i++) {
            if ($i >= $start && $i < ($start + $sublen)) {
                if (ord(substr($string, $i, 1)) > 129) {
                    $tmpstr .= substr($string, $i, 2);
                } else {
                    $tmpstr .= substr($string, $i, 1);
                }
            }
            if (ord(substr($string, $i, 1)) > 129) $i++;
        }
        if (strlen($tmpstr) < $strlen) $tmpstr .= "...";
        return $tmpstr;
    }
}

/**
 * 淘宝接口：根据ip获取所在城市名称
 * @param  string $ip [ 获取城市ip，为空时为本地ip ]
 * @return [type]     [ ip真实存在是返回查询数组，不存在 返回NULL ]
 *
 * demo
 *
 * var_dump(get_area());
 * var_dump(get_area('101.132.113.116'));
 */
function get_area($ip = '')
{
    if ($ip == '') {
        $ip = GetIp();
    }
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip={$ip}";
    $ret = https_request($url);
    $arr = json_decode($ret, true);

    if($arr['code'] == '0') {
        if ($ip == '127.0.0.1') {
           $area = '内网ip';
        } else {
            $area = $arr['data']['city'].$arr['data']['region'];
        }
    } else {
        $area = '未知';
    }
    return $area;
}



if (!function_exists('https_request')) {
    /**
     * GET,POST传参 curl调用接口链接返回状态
     * @param  [type] $url  [访问的接口链接]
     * @param  [type] $data [传参数据]
     * @return [type]       [返回url处理后的json数据]
     *
     * demo
     * echo https_request('http://localhost/other/my_php/data.php?id=1&name=zhangsan');
     * echo https_request('http://localhost/other/my_php/data.php',array('id'=>'1','name'=>'zhangsan'));
     *
     */
    function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        if(!empty($data)){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}

if(!function_exists('get_access_token_code')) {
    /**
     * 拉取授权页面
     * @return mixed
     */
    function get_access_token_code($Appid, $redirect_uri, $scope)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$Appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=123456#wechat_redirect";
        
       return $url;
        
    }
}

if(!function_exists('get_access_token')) {
    /**
     * 授权成功后获取access_token,openid
     * @return mixed
     */
    function get_access_token($Appid, $Secret, $Code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$Appid."&secret=".$Secret."&code=".$Code."&grant_type=authorization_code";
        $res = https_request($url);
        $res = json_decode($res, true);
        
        return $res;
    }
}

if(!function_exists('get_refresh_token')) {
    /**
     * 刷新access_token
     * @return mixed
     */
    function get_refresh_token($Appid, $Refresh_token)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$Appid."&grant_type=refresh_token&refresh_token=".$Refresh_token;
        $res = https_request($url);
        $res = json_decode($res, true);
        
        return $res;
    }
}

if(!function_exists('get_weixin_userinfo')) {
    /**
     * 授权成功后获取access_token,openid
     * @return mixed
     */
    function get_weixin_userinfo($Access_token, $Openid, $Lang)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$Access_token."&openid=".$Openid."&lang=".$Lang;
        $res = https_request($url);
        $res = json_decode($res, true);
        
        return $res;
    }
}


if(!function_exists('get_jssdk_access_token')) {
    /**
     * 授权成功后获取 access_token jsapi 使用
     * @return mixed
     */
    function get_common_access_token($Appid, $Secret)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$Appid."&secret=".$Secret;
        $res = https_request($url);
        $res = json_decode($res, true);
        
        return $res;
    }
}

if(!function_exists('get_jssdk_ticket')) {
    /**
     * 授权成功后获取 ticket jsapi 使用
     * @return mixed
     */
    function get_jssdk_ticket($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
        $res = https_request($url);
        $res = json_decode($res, true);
        
        return $res;
    }
}

function getIp() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                $ip = getenv("REMOTE_ADDR");
            else
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                    $ip = $_SERVER['REMOTE_ADDR'];
                else
                    $ip = "unknown";
    return ($ip);
}

//将XML转为array
function xmlToArray($xml){
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $values;
}


/**
 * 数据库操作相关函数
 */

    // 查询单条数据
    function get_Field_Find_One($table='', $field='*', $where=array(), $limit='0', $page='', $order='')
    {
        if(!empty($table)) {

            $datas = think\Db::table($table)->field($field)->where($where)->page($page, $limit)->order($order)->find();

            return $datas;
        } else {
            return 'table is not found';
        }
    }


    // 查询多条数据
    function get_Field_Find_All($table='', $field='*', $where=array(), $limit='0', $page='', $order='')
    {
        if(!empty($table)) {
            if (empty($where)) {
                $where = '';
            }
            $datas = think\Db::table($table)->field($field)->where($where)->page($page, $limit)->order($order)->select();

            return $datas;
        } else {
            return 'table is not found';
        }
    }


    // 添加一条数据   
    function SaveOneData($table='', $datas='', $return_id = false)
    {
       if(!empty($table)) {
            
            $result = think\Db::table($table)->insert($datas);

            if($return_id) {
                // 返回添加记录 id
                $Id = think\Db::name($table)->getLastInsID();
                return $Id;
            } else {
                return $result;

            }
        } else {
            return 'table is not found';
        }
    }

    // 批量添加多条数据
    function SaveMoreData($table='', $datas='')
    {
       if(!empty($table)) {

            if(!empty($datas)) {
                
                $result = think\Db::table($table)->insertAll($datas);

                return $result;
            } else {

                return 'datas is not found';
            }
        } else {

            return 'table is not found';
        }
    }

    // 修改数据
    function updateDatas($table='', $where='', $datas=''){

        if(!empty($table)) {

            if (empty($where)) {

                return 'where is error';
            }

            if(!empty($datas)) {
                
                $result = think\Db::table($table)->where($where)->update($datas);

                return $result;
            } else {

                return 'datas is not found';
            }
        } else {

            return 'table is not found';
        }
    }

    // 删除数据
    function deleteDatas($table='', $where=''){

        if(!empty($table)) {

            if (empty($where)) {

                return 'where is error';
            } else {
                 $result = think\Db::table($table)->where($where)->delete();

                return $result;
            }

        } else {

            return 'table is not found';
        }
    }



/**
 * end 数据库操作相关函数
 */