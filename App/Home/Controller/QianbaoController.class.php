<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/8
     * Time: 14:32
     */
    namespace Home\Controller;
    use Vendor\Page;
    class QianbaoController extends ComController{
        public function _initialize ()
        {
            parent::_initialize();
            if (!session('hid')){
                $this->display('User/login');
                exit;
            
            }
        }
        public function index(){
            $uid=session ('hid');
            $user=M('user');
            $account=M('account');
            $data=$user->where ('id='.$uid)->find ();
            $msg=array ();
            
            $date1=$account->where ('type=0 and user_id='.$uid)->Sum('amount');
            $date2=$account->where ('type=7 and user_id='.$uid)->Sum('amount');
            $date3=$account->where ('type=8 and user_id='.$uid)->Sum('amount');
            $date4=$account->where ('type=10 and user_id='.$uid)->Sum('amount');
           
            if (!$date1){
                $date1="0.00";
            }
            if (!$date2){
                $date2="0.00";
            }
            if (!$date3){
                $date3="0.00";
            }
            if (!$date4){
                $date4="0.00";
            }
            
            $this->assign ('date1',$date1);
            $this->assign ('date2',$date2);
            $this->assign ('date3',$date3);
            $this->assign ('date4',$date4);
            $this->assign ('data',$data);
            $this->display('qianbao/qianbao');
        }
        public function mingxi(){
            $user=M('account');
            $id=session('hid');
            
         
           
    
            $data=$user->where('type in(0,7,8) and user_id='.$id)->order('time desc')->select();
            
       
          
            
           
            $this->assign('data',$data);
            $this->display('Mingxi/mingxi');
        }
        public function mingxiss(){
            $mingxi=M('jifen');
            $id=session('hid');
            $data=$mingxi->where('uid='.$id)->select();
            $this->assign('data',$data);
            $this->display('Mingxi/mingxiss');
        }
    }