<?php
/**
 *
 * 版权所有：素材火<qwadmin.sucaihuo.com>
 * 作    者：素材水<hanchuan@sucaihuo.com>
 * 日    期：2016-09-20
 * 版    本：1.0.0
 * 功能说明：后台首页控制器。
 *
 **/

namespace Qwadmin\Controller;

class IndexController extends ComController
{
    public function index()
    {

        $model = new \Think\Model();
        $mysql = $model->query("select VERSION() as mysql");
        $p = isset($_GET['p']) ? intval($_GET['p']) : '1';
        $t = time() - 3600 * 24 * 60;
        $log = M('log');
        $log->where("t < $t")->delete();//删除60天前的日志
        $pagesize = 25;#每页数量
        $offset = $pagesize * ($p - 1);//计算记录偏移量
        $count = $log->count();
        $list = $log->order('id desc')->limit($offset . ',' . $pagesize)->select();
        $page = new \Think\Page($count, $pagesize);
        $page = $page->show();
        $this->assign('list', $list);
        $this->assign('page', $page);

        $this->assign('mysql', $mysql[0]['mysql']);
        $this->assign('nav', array('', '', ''));//导航
        
        $this->display();
    }
}