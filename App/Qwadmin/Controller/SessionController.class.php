<?php
/**
 * Created by PhpStorm.
 * User: f
 * Date: 2019/3/14
 * Time: 9:17
 */

namespace Qwadmin\Controller;


class SessionController extends ComController
{
    public function edit($aid)
    {
        $aid = intval($aid);
        $session = M('session')->where('id='.$aid)->find();
        if ($session)
        {
            $this->assign('session',$session);
        }
        $this->display('form');
    }


    public function index($sid = 0, $p = 1)
    {


        $p = intval($p) > 0 ? $p : 1;

        $session = M('session');
        $pagesize = 15  ;#每页数量
        $offset = $pagesize * ($p - 1);//计算记录偏移量
        $prefix = C('DB_PREFIX');
//        $sid = isset($_GET['sid']) ? $_GET['sid'] : '';
        $keyword = isset($_GET['keyword']) ? htmlentities($_GET['keyword']) : '';
        $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
        $where = '1 = 1 ';
//        if ($sid) {
//            $sids_array = category_get_sons($sid);
//            $sids = implode(',',$sids_array);
//            $where .= "and {$prefix}session.sid in ($sids) ";
//        }
        if ($keyword) {
            $where .= "and {$prefix}session.name like '%{$keyword}%' ";
        }
        //默认按照时间降序
        $orderby = "time desc";
        if ($order == "asc") {

            $orderby = "time asc";
        }



        $count = $session->where($where)->count();
        $list = $session->field("{$prefix}session.*")->where($where)->order($orderby)->limit($offset . ',' . $pagesize)->select();

        $page = new \Think\Page($count, $pagesize);
        $page = $page->show();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->display();
    }


    public function add()
    {

//        $category = M('category')->field('id,pid,name')->order('o asc')->select();
//        $tree = new Tree($category);
//        $str = "<option value=\$id \$selected>\$spacer\$name</option>"; //生成的形式
//        $category = $tree->get_tree(0, $str, 0);
//        $this->assign('category', $category);//导航
        $this->display('form');
    }

    public function update()
    {

        $aid = isset($_POST['aid']) ? intval($_POST['aid']): 0;
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : false;
       
        $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

      
        $data['time'] = strtotime($_POST['time']);

        $data['end_time'] = $data['time'] + 3600;
        if ($aid) {
            M('session')->data($data)->where('id=' . $aid)->save();
            $da['session_time'] = $data['time'];
            M('auction_info')->data($da)->where('session_id='.$aid)->save();
            addlog('编辑场次，AID：' . $aid);
            $this->success('恭喜！场次编辑成功！');
        } else {
            $aid = M('session')->data($data)->add();
            if ($aid) {
                addlog('新增场次，AID：' . $aid);
                $this->success('恭喜！场次新增成功！');
            } else {
                $this->error('抱歉，未知错误！');
            }

        }
    }

    public function del()
    {

        $aids = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : false;
        if ($aids) {
            if (is_array($aids)) {
                $aids = implode(',', $aids);
                $map['id'] = array('in', $aids);
            } else {
                $map = 'id=' . $aids;
            }
            if (M('session')->where($map)->delete()) {
                addlog('删除场次，AID：' . $aids);
                $this->success('恭喜，场次删除成功！');
            } else {
                $this->error('参数错误！');
            }
        } else {
            $this->error('参数错误！');
        }

    }

}