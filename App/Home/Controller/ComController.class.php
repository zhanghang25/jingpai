<?php
/**
 *
 * 版权所有：素材火<qwadmin.sucaihuo.com>
 * 作    者：素材水<hanchuan@sucaihuo.com>
 * 日    期：2016-01-21
 * 版    本：1.0.0
 * 功能说明：前台公用控制器。
 *
 **/

namespace Home\Controller;

use Think\Controller;

class ComController extends Controller
{

    public function _initialize()
    {
       
        /*
        $links = M('links')->limit(10)->order('o ASC')->select();
        $this->assign('links',$links);
        */
    
       $auctions =  M('auction_info')->where('status = 1')->select();
       
     /* var_dump ($auctions);echo time ();exit;*/
       for($i = 0;$i < count($auctions);$i++)
       {
           
           $time = time();
           if($auctions[$i]['end_time'] < ($time-1) )
           {
               
               $update_set['status'] = 2;
    
               
               $biddings = M('bidding')->where('auction_id='.$auctions[$i]['id'])->order("time desc")->select();
               $biddings1 = M('bidding')->where('auction_id='.$auctions[$i]['id'])->group('user_id')->select();
               $res=M('bidding')->where('auction_id='.$auctions[$i]['id'])->order("price desc")->find();
               $ss= M('bidding')->where('auction_id='.$auctions[$i]['id'])->group('user_id')->select();
               $ss=count($ss);
               
               if (count($biddings1)<=1){
                   M('auction_info')->data($update_set)->where('id='.$auctions[$i]['id'])->save();
               }
            
            
              
               if ($ss>1){
                  
                   $tmp_ids = [];
                   
                   foreach ($biddings as $bidding )
                   {
                       //去除出价最高的人
                       array_push($tmp_ids,$bidding['user_id']);
        
                       if($bidding['user_id'] == $res['user_id'])
                       {
                           array_pop($tmp_ids);
                       }
                   }
                   $ids = array_unique($tmp_ids);
                   
                   if($ids){
                       $where['id'] = array('in',$ids);
                     M('user')->where($where)->setInc('guaranty',$auctions[$i]['guaranty']);
                       M('user')->where($where)->setDec('freeze',$auctions[$i]['guaranty']);
                       foreach($ids as $id)
                       {
                           getAccount($id,$time,$auctions[$i]['guaranty'],9,1);
                           getAccount($id,$time,$auctions[$i]['guaranty'],11,1);
                       }
                       $updata_set['auction_person'] = implode(',',$ids);
                   }
                   $update_set['user_id'] = $biddings[0]['user_id'];
                   M('auction_info')->data($update_set)->where('id='.$auctions[$i]['id'])->save();
               }
             
               //最高成交价人上级，反拍额加1
              if ($biddings){
    
                  $success_man = M('user')->where('id='.$biddings[0]['user_id'])->find();
                  /*M('user')->where('id='.$success_man['parent_id'])->setInc('anti_money',1);*/
                  /*var_dump ($success_man);exit;*/
                  //登记日志信息
                  /*  getAccount($biddings[0]['user_id'],$time,1,7,3);*/
                  //更新bidding表状态
    
                  M('bidding')->where("auction_id=".$auctions[$i]['id'])->setInc('status',2);
                  M('bidding')->where('id='.$biddings[0]['id'])->setDec('status',1);
    
                  $logistic['sid'] = $auctions[$i]['shop_id'];
                  $logistic['status'] = 1;
                  $logistic['uid'] = $success_man['id'];
                  $logistic['placetime'] = time();
                  $logistic['logistics_price'] = 0;
                  $logistic['shop_name'] = $auctions[$i]['shop_name'];
                  $logistic['shop_price'] = $biddings[0]['price'] ;
                  $logistic['pic'] = $auctions[$i]['thumbnail'];
                  $logistic['bianhao'] = 'E'.date("YmdHis").rand(100000,999999);
                  $logistic['aid']=$biddings[0]['auction_id'];
    
                  M('logistics')->data($logistic)->add();
    
                  //短信消息提醒
                  $statusStr = array(
                      "0" => "短信发送成功",
                      "-1" => "网络错误",
                      "-2" => "网络错误",
                      "30" => "密码错误",
                      "40" => "网络错误",
                      "41" => "网络错误",
                      "42" => "网络错误",
                      "43" => "网络错误",
                      "50" => "网络错误"
                  );
    
                  $smsapi = "http://www.smsbao.com/"; //短信网关
                  $user = "linxipai"; //短信平台帐号
                  $pass = md5("linxipai"); //短信平台密码
                  $content="【多拍商城】尊敬的客户您好，恭喜您于".date('Y-m-d H:i:s')."成功拍下商品一件。请到平台'个人中心'-'我的订单'进行支付，
￥".$logistic['shop_price']."元的".$logistic['shop_name']."商品";//要发送的短信内容
                  $phone = $success_man['phone_num'];
    
                  $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
                  $result =file_get_contents($sendurl) ;
                  file_put_contents(abc.txt,$result);
                  
              }
              
           }
       }



    }
}