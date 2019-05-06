<?php
/**
 * Created by PhpStorm.
 * User: f
 * Date: 2019/3/14
 * Time: 9:17
 */

namespace Qwadmin\Controller;


use Think\Model;

class UserController extends ComController
{

    public function verify_phone_num()
    {
        $phone_num = I('post.phone_num');
        $verify_phone_num = M('user')->where("phone_num='".$phone_num."'")->find();
        if($verify_phone_num)
        {
            $this->ajaxReturn("您的手机号已经注册");
        }
        return;
    }

    public function verify_name()
    {
        $name = I('post.name');

        $verify_name = M('user')->where("name='".$name."'")->find();
        if($verify_name)
        {
            $this->ajaxReturn("您的用户名已经注册");
        }
        return;



    }

    public function index($sid = 0, $p = 1)
    {


        $p = intval($p) > 0 ? $p : 1;

        $user = M('user');
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
//            $where .= "and {$prefix}user.sid in ($sids) ";
//        }
        if ($keyword) {
            $where .= "and {$prefix}user.name like '%{$keyword}%' ";
        }
        //默认按照时间降序
        $orderby = "create_time desc";
        if ($order == "asc") {

            $orderby = "create_time asc";
        }



        $count = $user->where($where)->count();
        $list = $user->field("{$prefix}user.*")->where($where)->order($orderby)->limit($offset . ',' . $pagesize)->select();

        $page = new \Think\Page($count, $pagesize);
        $page = $page->show();

        foreach($list as $key => $value)
        {
            if(isset($value['parent_id']))
            {
               $parent_name = M('user')->field('name')->where('id='.$value['parent_id'])->find();
               $list[$key]['parent_name'] = $parent_name;
            }
        }
     foreach($list as  $k=>$v){
       if($v['parent_id']){
          $name=M('user')->where('id='.$v['parent_id'])->find();
       
       $list[$k]['parent_id']=$name['name'];
       }

     
     }
      
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

    public function edit()
    {
        $id = I('get.aid');
        $user = M('user')->where("id=".$id)->find();
        $this->assign('id',$id);
        $this->assign('user',$user);
        $this->display('form');
    }

    public function update($id = 0)
    {

        $id = intval(I('post.id'));
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : false;
        $data['point'] = I('post.point');
        $data['available_balance'] = I('post.available_balance');
        $data['guaranty'] = I('post.guaranty');
        $data['freeze'] = I('post.freeze');
        $data['anti_money'] = I('post.anti_money');

        $data['phone_num'] = I('post.phone_num');
        $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $data['ming_password'] = I('post.ming_password');

        $data['password'] = md5(I('post.ming_password').config['salt']);
        if ($id) {
            M('user')->data($data)->where('id=' . $id)->save();
            addlog('编辑客户，AID：' . $id);
            $this->success('恭喜！客户编辑成功！');
        } else {
            $data['create_time'] = time();
            while(true){
            $tmp = substr(md5(uniqid(microtime(true),true)),1,6);
                $source = M('user')->where('invite_code="'.$tmp.'"')->find();
                if($source)
                {
                    $tmp = substr(md5(uniqid(microtime(true),true)),1,6);
                }else{
                    break;
                }
            }
            $data['invite_code'] = $tmp;




            $id = M('user')->data($data)->add();
            if ($id) {
                addlog('新增客户，AID：' . $id);
                $this->success('恭喜！客户新增成功！');
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
            if (M('user')->where($map)->delete()) {
                addlog('删除客户，AID：' . $aids);
                $this->success('恭喜，客户删除成功！');
            } else {
                $this->error('参数错误！');
            }
        } else {
            $this->error('参数错误！');
        }

    }

}