<?php
    namespace Home\Controller;
    
    use Vendor\Page;
    
    class AuctionShopController extends ComController
    {
        public function showShop()
        {
            if (empty(session('hid')))
            {
                $this->display('User/login');
            }else{
                
                $id = I('param.id');
                $time = time();
                $auction =  M('auction_info')->where("id=".$id)->find();
                if ($auction['status'] == 0&& $auction['start_time']<=$time&&$auction['end_time']>=$time)
                {
                    $update_set['status'] = 1;
                    M('auction_info')->data($update_set)->where('id='.$auction['id'])->save();
                    $auction['status'] = 1;
                }
                if ($auction['status'] == 1&& $auction['start_time']<=$time&&$auction['end_time']<=$time)
                {
                    $update_set['status'] = 2;
                    M('auction_info')->data($update_set)->where('id='.$auction['id'])->save();
                    $auction['status'] = 2;
                }
                $this->assign('auction',$auction);
                $this->display();
            }
        }
        
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
        
        public function add_bid()
        {
            $time = time();
         
            $heig=M('auction_info');
            $price = I('post.price');
            $auction_id = I('post.auction_id');
            $high_price =$heig->where('id='.$auction_id)->find()['high_price'];
            
            $user = M('user')->where('id='.session('hid'))->find();
            $auction = M('auction_info')->where("id=".$auction_id)->find();
            
            $judge_user = M('bidding')->where('auction_id='.$auction_id.' and user_id='.$user['id'])->select();
            
            $data['auction_id'] = $auction_id;
            $data['profit'] = C("two_profit");
            $data['price'] = $price;
            $data['status'] = 0;
            $data['user_id'] = session('hid');
            $data['time'] = getMillisecond();
            $biddings2 = M('bidding')->where('auction_id='.$auction_id)->order("time desc")->select();
            if(getMillisecond()-$biddings2[0]['time']<3000)
            {
                
                $data5['code'] = 2;
                $data5['msg'] = "参与人数过多，请稍后";
                $this->ajaxReturn($data5);
            }
            
            //如果首次加价，并且保证金够，将保证金扣除到冻结金里
            if(empty($judge_user)){
                
                $data1['guaranty'] = $user['guaranty']-$auction['guaranty'];
                
                $data1['freeze'] = $user['freeze']+$auction['guaranty'];
                M('user')->data($data1)->where('id='.session('hid'))->save();
                getAccount(session('hid'),$time,$auction['guaranty'],2,4);
                getAccount(session('hid'),$time,$auction['guaranty'],10,4);
            }
            
            
            //当拍卖结束，用户还停留在加价页面，提示退出到主页
            $test_auction = M('auction_info')->where("id=".$auction_id)->find();
            if($test_auction['status'] == 2)
            {
                $data4['msg'] = "拍卖已结束，请参与下次竞拍！";
                $data4['error'] = 1;
                $data['code'] = 1;
                $this->ajaxReturn($data4);
            }
           
            //拍卖次数加一
            
            //所有加价信息状态置0
//        $data['status'] = 0;
//        M('bidding')->data($data)->where("auction_id=".$auction_id)->save();
//        $add_price = intval(I('post.add_price'));
           $datas['price'] =array ('eq',$price);
           $datas['auction_id'] =array('eq',$auction_id);
           
            $dataw['auction_id']=array('eq',$auction_id);
           /* $dataw['price']=array ('eq',$price);*/
            $ghja=M('bidding')->where($datas)->find();
            $datakk=M('bidding')->where($dataw)->order('price desc')->find();
            if ($price<=$datakk['price']){
                $data5['code'] = 2;
                $data5['msg'] = "参与人数过多，请稍后";
                $this->ajaxReturn($data5);
            }
            if ($ghja){
                $data5['code'] = 2;
                $data5['msg'] = "参与人数过多，请稍后";
                $this->ajaxReturn($data5);
            }
            //$biddings2 = M('bidding')->where('auction_id='.$auction_id)->order("time desc")->find();
            
            $res = M('bidding')->data($data)->add();
            if($res){
                
                $data1['msg'] = "恭喜您，加价成功！！";
    
                M('auction_info')->where("id=".$auction_id)->setInc('success_times',1);
            }else{
                
                $data1['msg'] = "抱歉，加价入库失败！！";
            }
            //获取所有的加价信息
            $biddings = M('bidding')->where('auction_id='.$auction_id)->order("time desc")->select();
            //加入返佣
            
            if(count($biddings)>1)
            {
                $user_id = $biddings[1]['user_id'];
                $user = M('user')->where('id='.$user_id)->find();
                
                //加入二级返佣
                M('user')->where('id='.$user_id)->setInc('available_balance',C('two_profit'));
                getAccount($user_id,$time,C("two_profit"),0,1);
                //加入一级返佣
                M('user')->where('id='.$user['parent_id'])->setInc('available_balance',C('one_profit'));
                getAccount($user['parent_id'],$time,C('one_profit'),0,1);
            }
            
            //在拍卖信息表里加入成交金额字段
            $data3['success_price']= $price;
            M('auction_info')->data($data3)->where("id=".$auction_id)->save();
            
            $data1['url'] = U('Home/AuctionShop/showShop',array('id'=>$auction_id));
            
            //达到最高成交价，拍卖结束
            if($price>=$high_price)
            {
                $data1['code'] = 1;
                //成交人
                $success_man = M('user')->where('id='.$biddings[0]['user_id'])->find();
                
                $data2['status'] = 2;
                $data2['user_id'] = $success_man['id'];
                $dsd = M('bidding')->where('auction_id='.$auction_id)->order("price desc")->find();
                //参拍人信息
                $tmp_ids = [];
                foreach ($biddings as $bidding )
                {
                    //$tmp_ids[] = $bidding['user_id'];
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
                    $data2['auction_person'] = implode(',',$ids);
                }
                //拍卖信息入库
                M('auction_info')->data($data2)->where("id=".$auction_id)->save();
                
                //用户以最高成交价成交，得商品最高成交价等额积分
                /*      M('user')->where('id='.$biddings[0]['user_id'])->setInc('point',$high_price);
                      getAccount($biddings[0]['user_id'],$time ,$high_price,8,2 );*/
                //最高成交价人上级，反拍额加1
                /* M('user')->where('id='.$success_man['parent_id'])->setInc('anti_money',1);
                 getAccount($success_man['parent_id'],$time,1,7,3);*/
                //更新bidding表状态
                
                
                M('bidding')->where("auction_id=".$auction_id)->setInc('status',2);
                M('bidding')->where('id='.$biddings[0]['id'])->setDec('status',1);
                
                $logistic['sid'] = $test_auction['shop_id'];
                $logistic['status'] = 1 ;
                $logistic['uid'] = $success_man['id'];
                $logistic['placetime'] = time();
                $logistic['logistics_price'] = 0;
                $logistic['shop_name'] = $test_auction['shop_name'];
                $logistic['shop_price'] = $high_price ;
                $logistic['pic'] = $test_auction['thumbnail'];
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
                file_put_contents(abc.txt,$result);
                $data1['url'] = U('Home/Order/orders');
                $data1['msg'] = "恭喜您，已成功拍得商品，将跳转到订单列表页，支付您的拍得商品";
            }
            
            $this->ajaxReturn($data1);
            
        }
        
        public function per_time()
        {
            
            $auction_id = I('get.auction_id');
            $bidding_id = I('get.bidding_id');
            $status = I('get.status');
            $data['code'] = 1;
//        if($status == 2)
//        {
//            $data['code']  = 2;
//            $this->ajaxReturn($data);
//        }
            $data['data'] = M('bidding')
                ->alias('b')
                ->where(array('auction_id'=>$auction_id))
                ->join("LEFT JOIN qw_user AS u ON b.user_id=u.id ")
                
                ->order("time DESC ")
                ->field("b.*,u.name")
//                                   ->field("b.*")
                ->select();
            $tmp['success_price'] = $data['data'][0]['price'];
            if (is_null ($tmp['success_price'])){
                $tmp['success_price']=0;
            }
            M('auction_info')->where('id='.$auction_id)->data($tmp)->save();
            $auction = M('auction_info')->where("id=".$auction_id)->find();
            if($auction['status'] == 2)
            {
                $data['statu'] = 2;
            }
            $data['price'] = $tmp['success_price'];
            $data['length'] = count($data['data']);
            $this->ajaxReturn($data);
        }
        
        
        public function convert()
        {
            $auction_id = I('post.auction_id');
            $auction = M('auction_info')->where('id='.$auction_id)->find();
            if($auction['status'] ==2)
            {
                $data2['data'] = 3;
                $data2['msg'] = "拍卖已结束！！";
                $this->ajaxReturn($data2);
            }
            
            if($auction['status'] == 0)
            {
                $data3['data'] = 4;
                $data3['msg'] = "拍卖还未开始！！" ;
                $this->ajaxReturn($data3);
            }
            
            $time = time();

//        $bidding = M('bidding')->where('auction_id='.$auction_id)->select();
//        if(empty($bidding))
//        {
//            $data['data'] = 2;
//            $this->ajaxReturn($data);
//        }
            
            $res = I('post.res');
            //判断是否为间歇
//        if($res == 0)
//        {
//
//            $data2['data'] = 1;
//            $data2['msg'] = "拍卖信息整理中！！";
//            $this->ajaxReturn($data2);
//        }
            
            
            
            $user = M('user')->where('id='.session('hid'))->find();
            
            
            
            //查询是否有用户加价记录
            $judge_user = M('bidding')->where('auction_id='.$auction_id.' and user_id='.$user['id'])->select();
            //判断用户保证金是否大于拍卖商品的保证金
            if(empty($judge_user)){
                
                if($auction['guaranty']>$user['guaranty'])
                {
                    $data['data'] = 0;
                    $this->ajaxReturn($data);
                }
                
                
                $data['data'] = 2;
                $this->ajaxReturn($data);
                
            }
            if($res == 0)
            {
                $data4['data'] = 1;
                $data4['msg'] = "正在整理拍卖信息，请稍候！";
                
                $this->ajaxReturn($data4);
            }
            
            
            
            
            
        }
        public function jilu(){
            $id=I('get.id');
            $jk=M ('user');
            $data=M('bidding')->where ('auction_id='.$id)->order('price desc')->group('price')->select();
            if ($data){
                $data[0]['as']='aa';
            }
            foreach($data as $k=>$v){
                $dat=$jk->where ('id='.$v['user_id'])->find ();
                $data[$k]['user_id']=$dat['name'];
            }
            $this->assign ('data',$data);
            
            $this->display ('Jilu/jilu');
        }
        public function fgh(){
           
            $id = I('param.id');
            $time = time();
            $auction =  M('auction_info')->where("id=".$id)->find();
            if ($auction['status'] == 0&& $auction['start_time']<=$time&&$auction['end_time']>=$time)
            {
                $update_set['status'] = 1;
                M('auction_info')->data($update_set)->where('id='.$auction['id'])->save();
                $auction['status'] = 1;
            
            }
            if ($auction['status']==1){
                $this->ajaxReturn(array ('code'=>1));
            }
        }
        
        
    }