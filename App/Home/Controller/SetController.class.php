<?php
    namespace Home\Controller;
    
    use Vendor\Page;
    use think\Controller;
    class SetController extends Controller
    {
       
        
        public function setOneToTwo()
        {   $time = time();
            $uid = session('hid');
            $auction_id = I('post.auction_id');
            
            $auction = M('auction_info')->where("id=".$auction_id)->find();
            
            //时间到结束
            if ($auction['status'] == 1)
            {
                $update_set['status'] = 2;
                
                $biddings = M('bidding')->where('auction_id='.$auction_id)->order("time desc")->select();
                $dsd = M('bidding')->where('auction_id='.$auction_id)->order("price desc")->find();
                $tmp_ids = [];
                foreach ($biddings as $bidding )
                {
                    //去除出价最高的人
                    array_push($tmp_ids,$bidding['user_id']);
                    
                    if($bidding['user_id'] == $dsd['user_id'])
                    {
                        array_pop($tmp_ids);
                    }
                }
                $ids = array_unique($tmp_ids);
                
                if($ids){
                    $where['id'] = array('in',$ids);
                    M('user')->where($where)->setInc('guaranty',$auction['guaranty']);
                    M('user')->where($where)->setDec('freeze',$auction['guaranty']);
                    foreach($ids as $id)
                    {
                        getAccount($id,$time,$auction['guaranty'],9,1);
                        getAccount($id,$time,$auction['guaranty'],11,1);
                    }
                    $updata_set['auction_person'] = implode(',',$ids);
                }
                $update_set['user_id'] = $biddings[0]['user_id'];
                M('auction_info')->data($update_set)->where('id='.$auction['id'])->save();
                //最高成交价人上级，反拍额加1
                
                
                $success_man = M('user')->where('id='.$biddings[0]['user_id'])->find();
                /* M('user')->where('id='.$success_man['parent_id'])->setInc('anti_money',1);*/
                
                //登记日志信息
                /* getAccount($uid,$time,1,7,3);*/
                //更新bidding表状态
                
                M('bidding')->where("auction_id=".$auction_id)->setInc('status',2);
                M('bidding')->where('id='.$biddings[0]['id'])->setDec('status',1);
                
                $logistic['sid'] = $auction['shop_id'];
                $logistic['status'] = 1;
                $logistic['uid'] = $success_man['id'];
                $logistic['placetime'] = time();
                $logistic['logistics_price'] = 0;
                $logistic['shop_name'] = $auction['shop_name'];
                $logistic['shop_price'] = $biddings[0]['price'] ;
                $logistic['pic'] = $auction['thumbnail'];
                $logistic['bianhao'] = 'E'.date("YmdHis").rand(100000,999999);
                $logistic['aid']=$auction_id;
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
                if(session('hid')==$success_man['id'])
                {
                    $datas['code'] = 1;
                    $datas['url'] = U("Home/Order/orders");
                    $datas['msg'] = "恭喜您，已成功拍得商品，将跳转到订单列表页，支付您的拍得商品";
                    $this->ajaxReturn($datas);
                    
                }
                /* file_put_contents(abc.txt,$result);*/
                
                
            }
            
        }
     
        
        
  
        
        
    }