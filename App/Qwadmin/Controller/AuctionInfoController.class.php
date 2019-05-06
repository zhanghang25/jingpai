<?php
/**
 * Created by PhpStorm.
 * User: f
 * Date: 2019/3/14
 * Time: 9:17
 */

namespace Qwadmin\Controller;


class AuctionInfoController extends ComController
{
    public function edit()
    {
        $id = I('get.aid');
        $this->assign('id',$id);

        $auction_info = M('auction_info')->where("id=".$id)->find();

        $this->assign('auction_info',$auction_info);
        if($auction_info['user_id']){

        $success_man = M('user')->field('name')->where('id='.$auction_info['user_id'])->find();
        //给成交人姓名赋值

        $this->assign('success_man',$success_man['name']);
        }
        if($auction_info['auction_person']){

        $tmp = $auction_info['auction_person'];
        $ids = explode(',',$tmp);
        $where['id'] = array('in',$ids);

        $part_man = M('user')->field('name')->where($where)->select();
        $particiment = '';
        for ($i = 0;$i < count($part_man);$i++)
        {
            if($i == 0){

            $particiment .= $part_man[$i]['name'];
            }else{

            $particiment .= ','.$part_man[$i]['name'];
            }
        }
        //给参拍人姓名赋值
        $this->assign('particiment',$particiment);
        }

        $sessions = M('session')->select();
        $this->assign('sessions',$sessions);
        $this->display('form');
    }

    public function auxtion_info()
    {

        $ids = I('post.ids');
        $start_time = I('post.start_time');
        $end_time = I('post.end_time');
        $session_time = intval(I('post.session_time'));

        $session_id = I('post.session_id');
        $end_time = strtotime($end_time);
        $start_time = strtotime($start_time);
        if($end_time<$start_time)
        {
            $this->ajaxReturn("您的拍卖结束时间小于了开始时间");
        }else{
            if ($end_time-$start_time>3600){
                $this->ajaxReturn("您的结束时间和开始时间间隔大于1小时");
            }
            if ($start_time>$session_time)
            {
                if($start_time-$session_time>3600)
                {
                    $this->ajaxReturn("您的开始时间超出场次时间");
                }

                if($end_time-$session_time>3600)
                {
                    $this->ajaxReturn("您的结束时间超出场次时间");
                }

            }else{
                $this->ajaxReturn("您的开始时间超出场次开始时间");
            }

        }
        $session = M('session')->where("id=".$session_id)->find();
        foreach ( $ids as $id )
        {
            //加入商品表信息
            $auction_info = M('auction_info')->where("id=".$id)->find();
            $auction['auction_info_name'] = $auction_info['name'];
            $auction['auction_info_time'] = $auction_info['addtime'];
            $auction['auction_info_status'] = $auction_info['status'];
            $auction['thumbnail'] = $auction_info['thumbnail'];
            $auction['carousel_figure1'] = $auction_info['carousel_figure1'];
            $auction['carousel_figure2'] = $auction_info['carousel_figure2'];
            $auction['carousel_figure3'] = $auction_info['carousel_figure3'];
            $auction['detail'] = $auction_info['detail'];
            $auction['start_price'] = $auction_info['start_price'];
            $auction['additional_shot_range'] = $auction_info['additional_shot_range'];
            $auction['reference_price'] = $auction_info['reference_price'];
            $auction['high_price'] = $auction_info['high_price'];
            $auction['guaranty'] = $auction_info['guaranty'];
            //加入场次表信息

            $auction['session_status'] = $session['status'];
            $auction['session_name'] = $session['name'];
            $auction['session_time'] = $session['time'];
            $auction['start_time'] = $start_time;
            $auction['end_time'] = $end_time;
            M('auction_info')->data($auction)->add();

        }

        $this->ajaxReturn("恭喜你，成功添加拍卖信息");



//        return json_encode($ids);

    }

    public function index($sid = 0, $p = 1)
    {


        $p = intval($p) > 0 ? $p : 1;

        $auction_info = M('auction_info');
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
//            $where .= "and {$prefix}auction_info.sid in ($sids) ";
//        }
        if ($keyword) {
            $where .= "and {$prefix}auction_info.shop_name like '%{$keyword}%' ";
        }
        //默认按照时间降序
        $orderby = "start_time desc";
        if ($order == "asc") {

            $orderby = "start_time asc";
        }



        $count = $auction_info->where($where)->count();
        $list = $auction_info->field("{$prefix}auction_info.*")->where($where)->order($orderby)->limit($offset . ',' . $pagesize)->select();

        $page = new \Think\Page($count, $pagesize);
        $page = $page->show();

        $sessions = M('session')->select();
//        print_r($sessions);
//        exit;
        $this->assign('sessions',$sessions);
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

    public function update($aid = 0)
    {

        $aid = intval(I('post.aid'));
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : false;
        $data['thumbnail'] = I('post.thumbnail', '', 'strip_tags');
        $data['carousel_figure1'] = I('post.carousel_figure1', '', 'strip_tags');
        $data['carousel_figure2'] = I('post.carousel_figure2', '', 'strip_tags');
        $data['carousel_figure3'] = I('post.carousel_figure3', '', 'strip_tags');
        $data['start_price'] = isset($_POST['start_price']) ? intval($_POST['start_price']) : 0;
        $data['additional_shot_range'] = isset($_POST['additional_shot_range']) ? intval($_POST['additional_shot_range']) : 0;
        $data['reference_price'] = isset($_POST['reference_price']) ? intval($_POST['reference_price']) : 0;
        $data['high_price'] = isset($_POST['high_price']) ? intval($_POST['high_price']) : 0;
        $data['guaranty'] = isset($_POST['guaranty']) ? intval($_POST['guaranty']) : 0;
        $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $data['start_time'] = strtotime($_POST['start_time']);
        $data['end_time'] = strtotime($_POST['end_time']);
        $data['session_id'] = $_POST['session_id'];
        $tmp_data = M('session')->where("id=".$data['session_id'])->find();
        $data['session_time'] = $tmp_data['time'];
        $data['detail'] = isset($_POST['detail']) ? $_POST['detail'] : false;
        $data['addtime'] = time();
        $data['short_show'] = $_POST['short_show'];
        
        if ($aid) {
            M('auction_info')->data($data)->where('id=' . $aid)->save();
            addlog('编辑商品，AID：' . $aid);
            $this->success('恭喜！商品编辑成功！');
        } else {
            $aid = M('auction_info')->data($data)->add();
            if ($aid) {
                addlog('新增商品，AID：' . $aid);
                $this->success('恭喜！商品新增成功！');
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
            if (M('auction_info')->where($map)->delete()) {
                addlog('删除商品，AID：' . $aids);
                $this->success('恭喜，商品删除成功！');
            } else {
                $this->error('参数错误！');
            }
        } else {
            $this->error('参数错误！');
        }

    }

}