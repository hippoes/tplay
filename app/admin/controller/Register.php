<?php 
namespace app\admin\controller;

use \think\Db;
use \think\Cookie;
use \think\Session;
use app\admin\model\Admin as adminModel;//管理员模型
use app\admin\model\AdminMenu;
use app\admin\controller\Permissions;
class Register extends Permissions
{
    protected $pagesize = '10';

	/**
     * 报名信息列表
     * @return [type] [description]
     */
    public function index()
    {
        // 获取问卷列表信息并设置分页
        $datas = Db::name('question')->field('id, question_title, update_time, user_id')->order('create_time asc')->paginate($this->pagesize);

        $question_datas = $datas->items();

        // 获取发布者昵称
        foreach ($question_datas as $k=>$v) {
            $username = get_Field_Find_One('tplay_admin', 'id, name', array('id' => $v['user_id']));
            $question_datas[$k]['username'] = !empty($username) ? $username['name'] : '';
        }

        $this->assign('question_datas', $question_datas);
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


    /**
     * 问卷表单数据展示列表
     */
    public function question_answer_list()
    {
        // 赋值传递
        $post = $this->request->param();

        if (!empty($post['id'])) {
            $id = $post['id'];

            // 获取对应报名问卷表头
            $question = get_Field_Find_One('tplay_question', 'id, question_title, question_config', array('id' => $id));
            $question_config = json_decode($question['question_config'], true);

            $where = "question_id = 'question_0".$id."'";

            // 获取对应的填写信息并设置分页
            $datas = Db::name('question_answer')->where($where)->order('create_time desc')->paginate($this->pagesize);

            // 取出对象中数据进行重新排版
            $AnswerDatas = $datas->items();
            // 遍历回答数据
            foreach ($AnswerDatas as $k=>$v) {
                $answer = json_decode($v['answer_datas'], true);
                $AnswerDatas[$k]['answer_datas'] = $answer;
                $AnswerDatas[$k]['ip'] = get_area($v['ip']);
            }
            // 去除表单字段名
            foreach ($question_config as $k=>$v) {
                $key[] = $v['title'];
            }

            $this->assign('question', $question);
            $this->assign('answer_datas', $key);
            $this->assign('AnswerDatas', $AnswerDatas);
            $this->assign('datas',$datas);
            return $this->fetch();

        } else {
            echo "数据获取错误";
        }
    }

    /**
     *  新增表单提交数据
     */
    public function question_answer_add()
    {
        // 赋值传递
        $post = $this->request->param();
        // 必须传入表单来源id（question_id）
        if (!empty($post) && !empty($post['question_id'])) {
            $id = $post['question_id'];
            // 根据问卷id获取问卷title
            $question = get_Field_Find_One('tplay_question', 'id, question_title, question_config', array('id' => $id));

            // 表单字段标题
            $question_config = json_decode($question['question_config'], true);
            foreach ($question_config as $k=>$v) {
                $key[] = $v['title'];
            }

            // 校验当前是否有提交数据并且时新增
            if (!empty($post['form_action']) && $post['form_action'] == 'add') {
               // 遍历保存新增表单信息
                foreach ($post as $key=>$value) {
                    if(strstr($key, 'question_name')) {
                        $answer_datas_edit[$key] = $value;
                    }
                }
                // 对固定数据及表单数据进行存储
                $saveData = array(
                    'question_id' => 'question_0'.$post['question_id'],
                    'answer_datas' => json_encode($answer_datas_edit),
                    'source' => $post['source'],
                    'create_time' => date('Y-m-d H:i:s', time()),
                    'ip' => getIp(),
                );
                // 写入数据表
                $lastId = SaveOneData('tplay_question_answer', $saveData, true);

                // 返回操作结果
                $returnDatas['errorcode'] = !empty($lastId) ? '0' : '30008';        // 30008 添加失败
                $returnDatas['message'] = !empty($lastId) ? '添加成功' : '添加失败';
                return json_encode($returnDatas);
            } else {

                // 返回空表单及需要参数
                $this->assign('type', 'add');
                $this->assign('question_id', $post['question_id']);
                $this->assign('key', $key);
                $this->assign('question', $question);
                return $this->fetch();
            }
        } else {
            $this->redirect('admin/register/index');
        }
    }

    /**
     * 修改报名数据信息
     */
    public function question_answer_edit()
    {
        // 赋值传递
        $post = $this->request->param();
        // 必须传入表单来源id（question_id）
        if (!empty($post) && !empty($post['question_id'])) {

            $question_id = $post['question_id'];    // 表单来源id
            $answer_id = $post['answer_id'];        // 表单回答内容id

            // 根据问卷id获取问卷title
            $question = get_Field_Find_One('tplay_question', 'id, question_title, question_config', array('id' => $question_id));

            // 表单字段标题
            $question_config = json_decode($question['question_config'], true);
            foreach ($question_config as $k=>$v) {
                $key[] = $v['title'];
            }

            // 校验当前是否有提交数据并且时编辑
            if(!empty($post['form_action']) && $post['form_action'] == 'edit') {
                // 遍历保存修改后表单信息
                foreach ($post as $key=>$value) {
                    if(strstr($key, 'question_name')) {
                        $answer_datas_edit[$key] = $value;
                    }
                }

                // 对固定数据及表单数据进行存储
                $saveData = array(
                    'update_time' => date('Y-m-d H:i:s', time()),
                    'answer_datas' => json_encode($answer_datas_edit),
                );

                // 更新数据表
                $where = array('id' => $answer_id);
                $result = updateDatas('tplay_question_answer', $where, $saveData);

                // 返回操作结果
                $returnDatas['errorcode'] = !empty($result) ? '0' : '30008';        // 30008 添加失败
                $returnDatas['message'] = !empty($result) ? '修改成功' : '修改失败';
                return json_encode($returnDatas);
            } else {

                // 获取原有数据进行表单填充
                $answer_datas = get_Field_Find_One('tplay_question_answer', '*', array('id' => $answer_id));
                
                // 表单数据 json 转为 数组
                $datas = json_decode($answer_datas['answer_datas'], true);
                
                $this->assign('answer_datas', $answer_datas);
                $this->assign('datas', $datas);
                $this->assign('type', 'edit');
            }

            $this->assign('key', $key);
            $this->assign('question', $question);
            return $this->fetch('question_answer_add');
        } else {
            $this->redirect('admin/register/index');
        }
    }


    /**
     * 删除报名信息表单
     */
    public function question_answer_del()
    {
        // 校验当前数据请求格式
        if($this->request->isAjax()) {

            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;

            if (!empty($id)) {
                // 删除当前 id 数据
                $result = deleteDatas('tplay_question_answer', array('id' => $id));

                // 返回操作结果
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

    /**
     *  导出数据到Excel
     */
    public function export_answer_datas()
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
    }


}