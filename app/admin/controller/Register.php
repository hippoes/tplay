<?php 
namespace app\admin\controller;
header('Content-type:text/html;charset=utf-8');

use \think\Db;
use \think\Cookie;
use \think\Session;
use app\admin\model\Admin as adminModel;//管理员模型
use app\admin\model\AdminMenu;
use app\admin\controller\Permissions;
class Register extends Permissions
{

	/**
     * 报名信息列表
     * @return [type] [description]
     */
    public function index()
    {
        // 获取问卷列表信息
        $datas = get_Field_Find_All('tplay_question', 'id, question_title, update_time, user_id', '', '', '', 'create_time asc');

        // 获取发布者昵称
        foreach ($datas as $k=>$v) {
            $username = get_Field_Find_One('tplay_admin', 'id, name', array('id' => $v['user_id']));
            $datas[$k]['username'] = $username['name'];
        }

        $this->assign('datas', $datas);
        return $this->fetch();
    }

    /**
     * 添加报名信息表
     */
    public function question_add()
    {
        // 赋值传递
        $post = $this->request->param();

        if (!empty($post)) {

            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
                ['question_title', 'require', '标题不能为空'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {
                dump($validate->getError());
            } else {
                // 将数据存入数据表中
                $saveData = array(
                    'question_title' => $post['question_title'],
                    'question_desc' => $post['question_desc'],
                    'question_lastdesc' => !empty($post['question_lastdesc']) ? $post['question_lastdesc'] : '',
                    'create_time' => date('Y-m-d H:i:s', time()),
                    'update_time' => date('Y-m-d H:i:s', time()),
                    'user_id' => !empty(session::get('admin')) ? session::get('admin') : '',                                       // 管理员id
                    'ip' => getIp(),
                    'jump_type' => $post['jump_type'],
                    'jump_text' => !empty($post['jump_text']) ? $post['jump_text'] : '',
                    'jump_href' => !empty($post['jump_href']) ? $post['jump_href'] : '',
                );

                // 写入数据表
                $lastId = SaveOneData('tplay_question', $saveData, true);

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
     * 编辑报名信息表单
     */
    public function question_edit()
    {
        // 表单提交参数保存
        $post = $this->request->param();

        // 修改后资料保存
        if(!empty($post['form_action']) && $post['form_action'] == 'edit') {

            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
                ['question_title', 'require', '标题不能为空'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {

                $returnDatas['errorcode'] = '30009';                // 数据校验失败
                $returnDatas['message'] = $validate->getError();    // 返回校验失败错误
                return json_encode($returnDatas);
            } else {
                $id = $post['id'];
                // 将数据修改保存到数据表中
                $saveData = array(
                    'question_title' => $post['question_title'],
                    'question_desc' => $post['question_desc'],
                    'question_lastdesc' => !empty($post['question_lastdesc']) ? $post['question_lastdesc'] : '',
                    'update_time' => date('Y-m-d H:i:s', time()),
                    'jump_type' => $post['jump_type'],
                    'jump_text' => !empty($post['jump_text']) ? $post['jump_text'] : '',
                    'jump_href' => !empty($post['jump_href']) ? $post['jump_href'] : '',
                );

                $where = array('id' => $id);
                $result = updateDatas('tplay_question', $where, $saveData);

                $returnDatas['errorcode'] = !empty($result) ? '0' : '30008';        // 30008 修改失败
                $returnDatas['message'] = !empty($result) ? '修改成功' : '修改失败';
                return json_encode($returnDatas);

            }

        } else if (!empty($post['id'])) {
           // 根据id 获取报名信息表单数据
            $field = 'id, question_title, question_desc, question_lastdesc, jump_type, jump_text, jump_href';
            $where = array('id'=> $post['id']);
            $datas = get_Field_Find_One('tplay_question', $field, $where);

           if (!empty($datas)) {

               $this->assign('type', 'edit');
               $this->assign('datas', $datas);

           }

            return $this->fetch('question_add');
        }
    }

    /**
     * 删除报名信息表单
     */
    public function question_del()
    {
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;

            if (!empty($id)) {
                $result = deleteDatas('tplay_question', array('id' => $id));

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


    // 问卷表单数据展示列表
    public function question_list()
    {
        // 赋值传递
        $post = $this->request->param();

        if (!empty($post['id'])) {
            $id = $post['id'];
            $where = "question_id = 'question_0".$id."'";

            $datas = get_Field_Find_All('tplay_question_answer', '*', $where, '', '', 'create_time desc');

            foreach ($datas as $k=>$v) {

                $datas[$k]['answer_datas'] = json_decode($v['answer_datas'], true);
                $datas[$k]['ip'] = get_area($v['ip']);
            }

//            dump($datas);

            foreach ($datas['0']['answer_datas'] as $k=>$v) {
                $key[] = $k;
            }

//            dump($key);

            $this->assign('answer_datas', $key);
            $this->assign('datas',$datas);
            return $this->fetch();

        } else {
            echo "数据获取错误";
        }

    }


}