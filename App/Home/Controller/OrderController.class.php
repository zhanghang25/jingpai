<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/3/27
     * Time: 10:37
     */
    
    namespace Home\Controller;
    use Think\Model;
    use Vendor\Page;
    
    class OrderController extends ComController
    {
    
        public function _initialize ()
        {
            parent::_initialize();
            if (!session('hid')){
                $this->display('User/login');
                exit;
            
            }
        }
        public function addAddress()
        {
            $logistics_id = I('post.id');
            $address_id = I('post.address_id');
            if(empty($address_id)){
                $data2['code'] = 1;
                $data2['msg'] = "您未添加收货地址，支付失败";
                $data2['url']=U('orderaddress/lists',array ('id'=>$logistics_id));
                $this->ajaxReturn($data2);
            }
         
            $logistics_id = I('post.id');
            $logistic = M('logistics')->alias('l')
                ->join("left join qw_shop as s on l.sid=s.id")->where('l.id='.$logistics_id)->field('l.shop_price,s.guaranty')->find();
            $data['address_id'] = $address_id;
            $asssp=M('address')->where('id='.$address_id)->find();
            $data['adddress_name']=$asssp['name'];
            $data['address']=$asssp['province'].$asssp['city'].$asssp['county'].$asssp['detailed'];

            $test =  M('logistics')->data($data)->where('id='.$logistics_id)->save();

        }
        public  function yu_e()
        {
            $logistics_id = I('post.id');
            $address_id = I('post.address_id');
            if(empty($address_id)){
                $data2['code'] = 1;
                $data2['msg'] = "您未添加收货地址，支付失败";
                $data2['url']=U('orderaddress/lists',array ('id'=>$logistics_id));
                $this->ajaxReturn($data2);
            }
           
            $logistics_id = I('post.id');
            $logistic = M('logistics')->alias('l')
                ->join("left join qw_shop as s on l.sid=s.id")->where('l.id='.$logistics_id)->field('l.shop_price,l.uid,s.guaranty')->find();
            $user = M('user')->where('id='.session('hid'))->find();
            if($user['available_balance']<$logistic['shop_price'])
            {
                $data1['code'] = 1;
                $data1['msg'] = "您的账户余额小于您的支付额，不能进行支付";
                $data1['url']=U('Order/orders');
                $this->ajaxReturn($data1);
            }
            $asse=M('logistics')->where('id='.$logistics_id)->find();
            if ($asse['status']==2){
                $data1['code'] = 1;
                $data1['msg'] = "您的订单已支付不能重复支付";
                $data1['url']=U('Order/orders');
                $this->ajaxReturn($data1);
            }
            $data['address_id'] = $address_id;
            $addfg=M('address')->where('id='.$address_id)->find();
            $data['adddress_name']=M('address')->where('id='.$address_id)->find()['name'];
            $data['address']=$addfg['province'].$addfg['city'].$addfg['county'].$addfg['detailed'];
            $data['status'] = 2;
            $test =  M('logistics')->data($data)->where('id='.$logistics_id)->save();
            $sss=  M('logistics')->where('id='.$logistics_id)->find();
          
            M('user')->where('id='.session('hid'))->setDec('available_balance',$sss['shop_price']);
            getAccount(session('hid'),time(),$sss['shop_price'],4,1);
         
            $shop = M('shop') ->where('id='.$sss['sid'])->find();
          
            M('user')->where('id='.$sss['uid'])->setDec('freeze',$shop['guaranty']);
            M('user')->where('id='.$sss['uid'])->setInc('guaranty',$shop['guaranty']);
         
            getAccount(session('hid'),time(),$shop['guaranty'],9,0);
            getAccount(session('hid'),time(),$shop['guaranty'],11,0);
          
          $aas=M('auction_info')->where('id='.$sss['aid'])->find();
           $success_man = M('user')->where('id='.session('hid'))->find();
                     M('user')->where('id='.$success_man['parent_id'])->setInc('anti_money',1);
                     $uid=session('hid');
                     $time=time();
                    //登记日志信息
                     getAccount($success_man['parent_id'],$time,1,7,3);
                     if ($sss['shop_price']>=$aas['high_price']){
                         M('user')->where('id='.session('hid'))->setInc('point',$aas['high_price']);
                         getAccount($uid,$time ,$aas['high_price'],8,2 );
                     }
                   
                    
            $data1['code'] = 2;
            $data1['msg'] = "支付成功！";
            $data1['url'] = U('Home/Order/orders');
            $this->ajaxReturn($data1);

        }

        public function commit()
        {
            $returnArray = array( // 返回字段
                "memberid" => $_REQUEST["memberid"], // 商户ID
                "orderid" =>  $_REQUEST["orderid"], // 订单号
                "amount" =>  $_REQUEST["amount"], // 交易金额
                "datetime" =>  $_REQUEST["datetime"], // 交易时间
                "transaction_id" =>  $_REQUEST["transaction_id"], // 支付流水号
                "returncode" => $_REQUEST["returncode"],
            );
            $md5key = "wtxemijw85ugrqzng7s1lf01niz69qg4";
            ksort($returnArray);
            reset($returnArray);
            $md5str = "";
            foreach ($returnArray as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
            $sign = strtoupper(md5($md5str . "key=" . $md5key));
            file_put_contents("success1.txt",$sign."\n".$_REQUEST['sign']."\n", FILE_APPEND);
            if ($sign == $_REQUEST["sign"]) {
                if ($_REQUEST["returncode"] == "00") {
                    $data['status'] = 2;
//                    $returnArray['orderid'] = 'E20190409180635222816';
                    M('logistics')->data($data)->where('bianhao="'.$returnArray['orderid'].'"')->save();
                    $order = M('logistics')->where('bianhao="'.$returnArray['orderid'].'"')->find();
                    $shop = M('auction_info')->where('id='.$order['aid'])->find();
                    M('user')->where('id='.$order['uid'])->setDec('freeze',$shop['guaranty']);
                    M('user')->where('id='.$order['uid'])->setInc('guaranty',$shop['guaranty']);
                    getAccount(session('hid'),time(),$shop['guaranty'],9,0);
                    getAccount(session('hid'),time(),$shop['guaranty'],11,0);
                    
                    $success_man = M('user')->where('id='.$order['uid'])->find();
                     M('user')->where('id='.$success_man['parent_id'])->setInc('anti_money',1);
                     $uid=$order['uid'];
                     $time=time();
                    //登记日志信息
                     getAccount($success_man['parent_id'],$time,1,7,3);
                      if($order['shop_price']>=$shop['high_price']){
                          M('user')->where('id='.$order['uid'])->setInc('point',$shop['high_price']);
                          getAccount($uid,$time ,$shop['high_price'],8,2 );
                      }
                   
                    
                    
                    //更新bidding表状态
                    $str = "支付成功！订单号：".$_REQUEST["orderid"];
                    file_put_contents("success.txt","1121"."\n", FILE_APPEND);
                    file_put_contents("success.txt",$str."\n", FILE_APPEND);
                    file_put_contents("success.txt","1111"."\n", FILE_APPEND);
                    exit("OK");
                }
            }
        }


        public function orders(){

           $wait_pay = M('logistics')->where('uid='.session('hid').' and status = 1')->order("placetime desc")->select();
           $this->assign('wait_pay',$wait_pay);

           $wait_deal =  M('logistics')->where('uid='.session('hid').' and status = 2')->order("placetime desc")->select();
            $this->assign('wait_deal',$wait_deal);

           $wait_delivery =  M('logistics')->where('uid='.session('hid').' and status = 3')->order("placetime desc")->select();
            $this->assign('wait_delivery',$wait_delivery);

            $deliveried =  M('logistics')->where('uid='.session('hid').' and status = 4')->order("placetime desc")->select();
            $this->assign('deliveried',$deliveried);

           $total =  M('logistics')->where('uid='.session('hid'))->order("status asc,placetime desc")->select();
          
           $this->assign('total',$total);

            $this->display();
        }

        public function address()
        {
            $uio=I('get.id');
            $user=M('address');

            $data=$user->where ('uid='.session('hid'))->order ('id asc')->select();
            if (!$data){
                $data=array();
            }
            if (count ($data)==1){
                $user->where ('uid='.session ('hid'))->save (array('default'=>1));
            }elseif (count ($data)>1){
                $map=array();
                $r=session('hid');
                $map['uid']=array('eq',$r);
                $map['default']=array('eq',1);
                $b=$user->where($map)->find();

                if (!$b){
                    $datq=$user->where ('uid='.session('hid'))->find();
                    $user->where('id='.$datq['id'])->save(array('default'=>1));
                }
            }
            $data=$user->where ('uid='.session('hid'))->order ('id asc')->select();

            if (!$data){
                $data=array();
            }
            $this->assign ('data',$data);
            $this->assign ('id',$uio);
            $this->display ();
        }

        public function  twoStep()
        {
            $id = I("get.id");
            $logistic = M("logistics")->where('id='.$id)->find();
            $this->assign('logistic',$logistic);
            $this->assign('id',$id);
            $this->display();

        }

        public function confirm()
        {
            $id = I("get.id");
            $data['status'] = 4;
            $result = M("logistics")->where("id=".$id)->data($data)->save();
            if($result)
            {
                $data1['code'] = 1;
                $data1['msg'] = "恭喜您，确认收货成功！";
            }else{
                $data1['msg'] = "很遗憾，确认收货失败！";
            }
           header ("Location:".U('Order/orders',array('ss'=>3)));

        }

        public function oneStep()
        {
            $user = M('user')->where('id='.session('hid'))->find();
            $id=I ('get.id');
            $auction = M('logistics')->where('id='.$id)->find();
            if ($auction['rt']==1){
                $ll['rt']=0;
               $pay_orderid = 'E'.date("YmdHis").rand(100000,9999999);    //订单号
            $ll['bianhao'] = $pay_orderid;
                M('logistics')->where('id='.$id)->save($ll);
            }
           
            $address=M('address');
            $msg=array ();
            $uid=session('hid');
            $msg['uid']=array('eq',$uid);
            $msg['default']=1;
            $address=$address->where($msg)->find();
            if (!$address){
                $address=array ();
            }

                $address['user_name'] = $user['name'];
                $address['phone'] = $user['phone_num'];


            $this->assign('address',$address);
            $this->assign('user',$user);
            $this->assign('auction',$auction);
            $this->assign('id',$id);
            error_reporting(0);
            header("Content-type: text/html; charset=utf-8");
            $pay_memberid = "10091";   //商户ID

            $pay_orderid = 'E'.date("YmdHis").rand(100000,9999999);    //订单号
            $data['bianhao'] = $pay_orderid;
            M('logistics')->data($data)->where('id='.$id)->save();

            $pay_amount = $auction['shop_price'];    //交易金额
            $pay_applydate = date("Y-m-d H:i:s");  //订单时间
//            $pay_notifyurl = "http://www.fnvig.cn/api/server.php";   //服务端返回地址
            $pay_notifyurl = "http://www.fnvig.cn/index.php/Home/Order/commit.html";   //服务端返回地址
            $pay_callbackurl = "http://www.fnvig.cn/index.php";  //页面跳转返回地址
//            $pay_callbackurl = "http://racimgjunk.com/index.php/Home/Index/index.html";  //页面跳转返回地址
            $Md5key = "wtxemijw85ugrqzng7s1lf01niz69qg4";   //密钥
            $tjurl = "http://api.rg92q.cn/Pay_Index.html";   //提交地址
            $pay_bankcode = "917";   //银行编码
//扫码
            $native = array(
                "pay_memberid" => $pay_memberid,
                "pay_orderid" => $pay_orderid,
                "pay_amount" => $pay_amount,
                "pay_applydate" => $pay_applydate,
                "pay_bankcode" => $pay_bankcode,
                "pay_notifyurl" => $pay_notifyurl,
                "pay_callbackurl" => $pay_callbackurl,
            );
            ksort($native);
            $md5str = "";
            foreach ($native as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
//echo($md5str . "key=" . $Md5key);
            $sign = strtoupper(md5($md5str . "key=" . $Md5key));
            $native["pay_md5sign"] = $sign;
            $native['pay_attach'] = "1234|456";
            $native['pay_productname'] ='VIP基础服务';
            $this->assign('native',$native);
            $this->assign('tjurl',$tjurl);
            $this->assign('pay_amount',$pay_amount);


            $this->display();
        }
        public function poi(){
            $id=I('get.size');
            $logistics=M('logistics')->where("bianhao='".$id."'")->find();
            if ($logistics['rt']==1){
                $pay_orderid = 'E'.date("YmdHis").rand(100000,9999999);
                $msg['bianhao']=$pay_orderid;
                
                $ss=M('logistics')->where('id='.$logistics['id'])->save($msg);
                $this->ajaxReturn(array ('bianhao'=>$pay_orderid,'code'=>1));
            }else{
                
                $sf['rt']=1;
                
                $ss=M('logistics')->where('id='.$logistics['id'])->save($sf);
                $this->ajaxReturn(array ('code'=>0));
            }
            
        }
    }