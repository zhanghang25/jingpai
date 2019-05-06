<?php
/**
 * Created by PhpStorm.
 * User: f
 * Date: 2019/3/14
 * Time: 9:17
 */

namespace Qwadmin\Controller;


class OrderController extends ComController
{
    public function edit()
    {
        $id = I('get.aid');
        $this->assign('id',$id);

        $logistics = M('logistics')->where("id=".$id)->find();

        $this->assign('logistics',$logistics);

        $this->display('form');
    }



    public function index($sid = 0, $p = 1)
    {


        $p = intval($p) > 0 ? $p : 1;

        $logistics = M('logistics');
        $pagesize = 15  ;#每页数量
        $offset = $pagesize * ($p - 1);//计算记录偏移量
        $prefix = C('DB_PREFIX');
//        $sid = isset($_GET['sid']) ? $_GET['sid'] : '';
        $keyword = isset($_GET['keyword']) ? htmlentities($_GET['keyword']) : '';
        $keyword1 = isset($_GET['keyword1']) ? htmlentities($_GET['keyword1']) : '';

        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $where = '1 = 1 ';
//        if ($sid) {
//            $sids_array = category_get_sons($sid);
//            $sids = implode(',',$sids_array);
//            $where .= "and {$prefix}logistics.sid in ($sids) ";
//        }
        if ($keyword) {
            $where .= " and qw_logistics.bianhao = '{$keyword}' ";
        }

        if(!empty($keyword1)){
            $where .= " and qw_logistics.status = ".$keyword1;
        }
        //默认按照时间降序
       

      
        $count = $logistics->where($where)->count();
        $address=M('address');
        $list = $logistics->join('qw_user as u on qw_logistics.uid=u.id',"LEFT")->field("*,u.name,u.phone_num,qw_logistics.status,qw_logistics.id")->where($where)->limit($offset . ',' . $pagesize)->order('placetime desc')->select();
        
        $page = new \Think\Page($count, $pagesize);
        $page = $page->show();

//        print_r($sessions);
//        exit;
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->display();
    }


    

    public function update($aid = 0)
    {

        $aid = intval(I('post.aid'));
        $data['logistics_number'] = isset($_POST['logistics_number']) ? $_POST['logistics_number'] : false;
        $data['logistics'] = isset($_POST['logistics']) ? $_POST['logistics'] : false;
        $data['status'] = isset($_POST['status']) ? $_POST['status'] : false;
        $data['adddress_name']=I('post.address_name');
        $data['address']=I('post.address');


        if ($aid) {
            M('logistics')->data($data)->where('id=' . $aid)->save();
            addlog('编辑订单，AID：' . $aid);
            $this->success('恭喜！订单编辑成功！');
        } else {
            $aid = M('logistics')->data($data)->add();
            if ($aid) {
                addlog('新增订单，AID：' . $aid);
                $this->success('恭喜！订单新增成功！');
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
            if (M('logistics')->where($map)->delete()) {
                addlog('删除订单，AID：' . $aids);
                $this->success('恭喜，订单删除成功！');
            } else {
                $this->error('参数错误！');
            }
        } else {
            $this->error('参数错误！');
        }

    }

}