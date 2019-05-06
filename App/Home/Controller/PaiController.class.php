<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/2
     * Time: 16:30
     */
    namespace Home\Controller;
    use vendor\Page;
    class PaiController extends ComController{
        public function _initialize ()
        {
            parent::_initialize();
            if (!session('hid')){
                $this->display('User/login');
                exit;
            
            }
        }
        public function index(){
            $pai=M('bidding');
            $ud=M('auction_info');
            $data1=$ud->join ("qw_bidding u on u.auction_id=qw_auction_info.id","LEFT")->field ('*,u.user_id,u.status,u.id')->where('u.status=0 and u.user_id='.session('hid'))->group('u.auction_id')->select();
            $data2=$ud->join ("qw_bidding u on u.auction_id=qw_auction_info.id","LEFT")->field ('*,u.user_id,u.status')->where('u.status=1 and u.user_id='.session('hid'))->select();
            $data3=$ud->join ("qw_bidding u on u.auction_id=qw_auction_info.id","LEFT")->field ('*,u.user_id,u.status')->where('u.status=2 and u.user_id='.session('hid'))->group('u.auction_id')->select();
            /*var_dump ($data2[1]);exit;*/
            foreach($data2 as $k=>$v){
                foreach($data3 as $key=>$value){
                    
                    if ($v['auction_id']==$value['auction_id']){
                        unset($data3[$key]);
                    }
                }
            }
            
            foreach($data1 as $v){
               
                if (time()+31>$v['end_time']){
                    $data6=$pai->where ('auction_id='.$v['auction_id'])->order('price desc')->find ();
                    $data7=$pai->where ('auction_id='.$v['auction_id'])->save (array ('status'=>2,'time'=>getMillisecond()));
                    if ($data7){
                        $pai->where ('id='.$data6['id'])->save (array ('status'=>1,'time'=>getMillisecond()));
                    }
                    $data8=$pai->where ('auction_id='.$v['auction_id'])->group('user_id')->select();
                    $a='';
                    foreach($data8 as $va){
                        $a.=$va['user_id'].',';
                        
                    }
                    $a=rtrim ($a,',');
                   
                    $msg=array ();
                    
                    $msg['user_id']=$data6['user_id'];
                    $msg['status']=2;
                    $msg['auction_person']=$a;
                    $ud->where('id='.$v['auction_id'])->save($msg);
                }
            }
            $pai=M('bidding');
            $ud=M('auction_info');
            $data1=$ud->join ("qw_bidding u on u.auction_id=qw_auction_info.id","LEFT")->field ('*,u.user_id,u.status,u.id')->where('u.status=0 and u.user_id='.session('hid'))->group('u.auction_id')->select();
            $data2=$ud->join ("qw_bidding u on u.auction_id=qw_auction_info.id","LEFT")->field ('*,u.user_id,u.status')->where('u.status=1 and u.user_id='.session('hid'))->select();
            $data3=$ud->join ("qw_bidding u on u.auction_id=qw_auction_info.id","LEFT")->field ('*,u.user_id,u.status')->where('u.status=2 and u.user_id='.session('hid'))->group('u.auction_id')->select();
            
            foreach($data2 as $k=>$v){
                foreach($data3 as $key=>$value){
            
                    if ($v['auction_id']==$value['auction_id']){
                        unset($data3[$key]);
                    }
                }
            }
            $data=array ();
            $data[]=$data1;
            $data[]=$data2;
            $data[]=$data3;
            
            $this->assign('data',$data);
            $this->display();
        }
    }