<?php 
namespace app\admin\controller;

use \think\Db;
use \think\Cookie;
use \think\Session;
use \think\Request;
use app\admin\model\Admin as adminModel;//管理员模型
use app\admin\model\AdminMenu;
use app\admin\controller\Permissions;

class Birthday extends Permissions
{
    protected $pagesize = '10';

	/**
     * 生日卡片信息列表
     * @return [type] [description]
     */
    public function card_list()
    {
        $request = request();

        // 获取问卷列表信息并设置分页
        $datas = Db::name('birthday_list')->field('*')->order('create_time desc')->paginate($this->pagesize);
        // 对象中住区数据
        $birthday_datas = $datas->items();
        // 域名信息
        $domain = $request->domain();

        // dump($birthday_datas);
        // exit;
        $this->assign('domain', $domain);
        $this->assign('birthday_datas', $birthday_datas);
        $this->assign('datas', $datas);
        return $this->fetch();
    }

    /**
     * 添加生日信息表
     */
    public function birthday_add()
    {
        // 赋值传递
        $post = $this->request->param();

        if (!empty($post)) {
            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
                ['username', 'require', '会员昵称不能为空'],
                ['birthday_time', 'require', '生日时间不能为空'],
                ['producers', 'require', '作者不能为空'],
            ]);

            //验证部分数据合法性
            if (!$validate->check($post)) {
                dump($validate->getError());
            } else {

                // 将数据存入数据表中
                $saveData = array(
                    'username' => $post['username'],
                    'birthday_time' => $post['birthday_time'],
                    'producers' => $post['producers'],
                    'create_time' => date('Y-m-d H:i:s', time()),
                    'update_time' => date('Y-m-d H:i:s', time()),
                );

                // 写入数据表, 返回插入数据id
                $lastId = SaveOneData('tplay_birthday_list', $saveData, true);

                // 更新合成链接到数据库
                $url = url('birthday/card/cardview', 'user_id='.$lastId.'&keyword=JLP');     // 合成访问链接
                $where = array('id' => $lastId);
                $result = updateDatas('tplay_birthday_list', $where, array('composite' => $url));

                $returnDatas['errorcode'] = !empty($lastId) ? '0' : '30008';        // 30008 添加失败
                $returnDatas['message'] = !empty($lastId) ? '添加成功' : '添加失败';
                return json_encode($returnDatas);
                
            }
        } else {
            $this->assign('type', 'add');
            return $this->fetch();
        }
    }

    /**
     * 编辑生日贺卡信息表单
     */
    public function birthday_edit()
    {
        // 表单提交参数保存
        $post = $this->request->param();

        // 修改后资料保存
        if(!empty($post['form_action']) && $post['form_action'] == 'edit') {

            //验证  唯一规则： 表名，字段名，排除主键值，主键名
             $validate = new \think\Validate([
                ['username', 'require', '会员昵称不能为空'],
                ['birthday_time', 'require', '生日时间不能为空'],
                ['producers', 'require', '作者不能为空'],
            ]);

            //验证部分数据合法性
            if (!$validate->check($post)) {

                $returnDatas['errorcode'] = '30009';                // 数据校验失败
                $returnDatas['message'] = $validate->getError();    // 返回校验失败错误
                return json_encode($returnDatas);
            } else {
                $id = $post['id'];

                // 合成访问链接
                // $url = url('birthday/card/cardview', 'username='.$post['username'].'&birthday_time='.$post['birthday_time']);
            
                // 将数据存入数据表中
                $saveData = array(
                    'username' => $post['username'],
                    'birthday_time' => $post['birthday_time'],
                    'producers' => $post['producers'],
                    // 'composite' => $url,
                    'update_time' => date('Y-m-d H:i:s', time()),
                );


                $where = array('id' => $id);
                $result = updateDatas('tplay_birthday_list', $where, $saveData);

                $returnDatas['errorcode'] = !empty($result) ? '0' : '30008';        // 30008 修改失败
                $returnDatas['message'] = !empty($result) ? '修改成功' : '修改失败';
                return json_encode($returnDatas);
            }

        } else if (!empty($post['id'])) {
           // 根据id 获取报名信息表单数据
            $field = '*';
            $where = array('id'=> $post['id']);
            $datas = get_Field_Find_One('tplay_birthday_list', $field, $where);

           if (!empty($datas)) {
               $this->assign('type', 'edit');
               $this->assign('datas', $datas);
           }

            return $this->fetch('birthday_add');
        }
    }

    /**
     * 删除生日贺卡信息表单
     */
    public function birthday_del()
    {
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;

            if (!empty($id)) {
               $result = deleteDatas('tplay_birthday_list', array('id' => $id));

                $returnDatas['errorcode'] = !empty($result) ? '0' : '30008';        // 30008 删除失败
                $returnDatas['message'] = !empty($result) ? '删除成功' : '删除失败';
                return json_encode($returnDatas);
            } else {
                $returnDatas['errorcode'] = '30008';        // 30008 删除失败
                $returnDatas['message'] = '删除失败';
                return json_encode($returnDatas);
            }
        }
    }

    // 生成二维码
    public function qrcode() {
        return '123';
    }
    

    /**
     *  导出数据到Excel
     */
    /*public function export_answer_datas()
    {
        // 赋值传递
        $post = $this->request->param();

        if (!empty($post['question_id'])) {
            // 表单来源id
            $id = $post['question_id'];

            // 获取对应报名问卷表头
            $question = get_Field_Find_One('tplay_question', 'id, question_title, question_config', array('id' => $id));
            $question_config = json_decode($question['question_config'], true);


            $where = "question_id = 'question_0".$id."'";
            // 获取对应的回答信息（全部）
            $datas = get_Field_Find_All('tplay_question_answer', '*', $where, '', '', 'create_time desc');

            // 数据进行遍历梳理
            $export_datas = array();
            foreach ($datas as $k=>$v) {
                // 回答数据进行 json 转 数组
                $answer = json_decode($v['answer_datas'], true);
                $export_datas[$k] = $answer;
                $export_datas[$k]['source'] = $v['source'];
                $export_datas[$k]['create_time'] = $v['create_time'];
                $export_datas[$k]['total_time'] = $v['total_time'].'秒';
                $export_datas[$k]['ip'] = get_area($v['ip']);
                $export_datas[$k]['equipment'] = $v['equipment'];
                $export_datas[$k]['id'] = $v['id'];
            }

            // 表单中字段title
            foreach ($question_config as $k=>$v) {
                $key[] = $v['title'];
            }
            // 存储文件名
            $filename = $question['question_title'].date('Y.m.d', time());

            // 固定表单title
            $key['soucrce'] = '来源';
            $key['create_time'] = '创建时间';
            $key['total_time'] = '填写时长';
            $key['ip'] = 'IP地址';
            $key['equipment'] = '设备';
            $key['id'] = 'ID';

            // title数组索引重置
            $key = array_values($key);

            // 导出数据
            vendor('PHPExcel.PHPExcel');
            $excel = new \PHPExcel();
            $excel->exportExcel($key, $export_datas, $filename, './', true);
        } else {
            echo "数据获取错误";
        }
    }*/


}