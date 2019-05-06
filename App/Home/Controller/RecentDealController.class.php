<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/25
 * Time: 11:16
 */
namespace Home\Controller;
use Vendor\Page;
class RecentDealController extends  ComController{
    public function showRecent()
    {
//        $biddings = M('bidding')->alias('b')
//            ->join("left join qw_user as u on b.user_id = u.id")
//            ->join("left join qw_auction_info as a on b.auction_id = a.id")
//            ->order('b.time desc')->limit(0,3)
//            ->where('b.status = 1')
//            ->field('b.*,a.id as aid,a.thumbnail,a.reference_price,u.name,a.shop_name')->select();
        $biddings = M('auction_info')->alias('a')
            ->join("left join qw_bidding as b on b.auction_id = a.id")
            ->join("left join qw_user as u on b.user_id = u.id")
            ->order('b.time desc')->limit(0,10)
            ->where('b.status = 1')
            ->field('b.*,a.id as aid,a.thumbnail,a.reference_price,u.name,a.shop_name')->select();


        for($i=0;$i < count($biddings);$i++)
        {
            $biddings[$i]['discount'] = ceil(($biddings[$i]['reference_price']-$biddings[$i]['price'])/$biddings[$i]['reference_price']*100);
            $biddings[$i]['time'] = intval(substr(strval($biddings[$i]['time']),0,10));

        }
//        var_dump ($biddings[2]);
        $this->assign('biddings',$biddings);
        $this->display();
    }

}