<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/8
     * Time: 15:42
     */
  
    namespace Home\Controller;
    use mysql_xdevapi\Session;
    use Vendor\Page;
    class  PayconfigController extends ComController{
        public function _initialize()
        {
            parent::_initialize();
            if (!session('hid')){
                $this->display('User/login');
                exit;
            
            }
        }
      public function zhifu(){
            $id=session('hid');
            $user=M('user');
            $data=$user->where ('id='.$id)->find ();
            $this->assign ('data',$data);
            $this->display ('User/zfgai');
      }
      public function zfgai(){
          $data=I('post.');
          $user=M('user');
          $id=session('hid');
          $msg['zhifu']=array('eq',$data['zhifu']);
          $msg['id']=$id;
          $name=$user->where($msg)->find();
          if ($name){
              return $this->ajaxReturn (array('code'=>0,'msg'=>'不可与当前支付宝号重复'));
          }
          $ty=$user->where('id='.$id)->save($data);
          if ($ty){
              return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U('personal/info')));
          }
      }
      public function weixin(){
          $id=session('hid');
          $user=M('user');
          $data=$user->where ('id='.$id)->find ();
          $this->assign ('data',$data);
          $this->display ('User/wxgai');
      }
      public function wxgai(){
          $data=I('post.');
          $user=M('user');
          $id=session('hid');
          $msg['wixin']=$data['weixin'];
          $msg['id']=$id;
          $name=$user->where($msg)->find();
          if ($name){
              return $this->ajaxReturn (array('code'=>0,'msg'=>'不可与当前微信号重复'));
          }
          $ty=$user->where('id='.$id)->save($data);
          if ($ty){
              return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U('personal/info')));
          }
      }
      public function tixian(){
            $id=I('get.is');
            $type=I('type');
            $this->assign('type',$type);
            $this->assign('id',$id);
            $this->display ('tixian/tixian');
      }
      
      public function diszhifubao(){
            $user=M('user');
            $type=I('get.type');
            $id=session ('hid');
            $data=$user->where ('id='.$id)->find ();
            $this->assign('type',$type);
            $this->assign ('data',$data);
            $this->display ('pay/zhifubao');
      }
      
     public function zhifugai(){
         $id=session('hid');
         $user=M('user');
         $type=I('get.type');
         $data=$user->where ('id='.$id)->find ();
         $this->assign ('data',$data);
         
         $this->assign('type',$type);
         $this->display ('pay/zfgai');
     }
     public function zhifubaogais(){
         $data=I('post.');
         $user=M('user');
         $id=session('hid');
        
         $type=$data['type'];
         unset($data['type']);
         $name=$user->where("zhifu='".$data['zhifu']."'")->find();
         if ($name){
             return $this->ajaxReturn (array('code'=>0,'msg'=>'不可与当前支付宝号重复'));
         }
         $ty=$user->where('id='.$id)->save($data);
         if ($ty){
             return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U('payconfig/diszhifubao',array('type'=>$type))));
         }
     }
     public function zfpays(){
        $value=I('post.');
        $id=session ('hid');
        $user=M('user');
        $tixian=M('tixian');
        $data=$user->where ('id='.$id)->find ();
        if (empty(trim($data['zhifu']))){
            $this->ajaxReturn (array ('code'=>0,'msg'=>'请设置支付宝账号'));
        }
        if ($value['money']<C('cash_money')){
            $this->ajaxReturn (array ('code'=>2,'msg'=>'提现不能小于最低额度'));
        }
         $dat['type']=$value['type'];
         if ($dat['type']==2){
             $data['available_balance']=(float)$data['available_balance']-(float)$value['money'];
             if ($data['available_balance']<0){
                 $this->ajaxReturn (array ('code'=>2,'msg'=>'您的账户余额不足'));
             }
         }elseif($dat['type']==1){
             $data['guaranty']=(float)$data['guaranty']-(float)$value['money'];
             if ($data['guaranty']<0){
                 $this->ajaxReturn (array ('code'=>2,'msg'=>'您的保证金余额不足'));
             }
         }
         
        $as=$user->where ('id='.$id)->save ($data);
        
        if ($as){
            $msg['zhanghu']=$data['zhifu'];
            $msg['zhanghuname']=$data['zhifuname'];
            $msg['time']=time ();
            $msg['status']=0;
            $msg['leixing']=1;
            $msg['user_id']=$id;
            $msg['price']=$value['money']*((100-C('cash_fei'))/100);
            $msg['type']=$value['type'];
            $tixian=$tixian->add($msg);
            if($tixian){
                $this->ajaxReturn (array ('code'=>1,'msg'=>'提现申请已提交，将在7个工作日内到账','url'=>U('qianbao/index',array ('type'=>$value['type']))));
            }
            
        }
        }
        public function diswexin(){
            $user=M('user');
            $id=session ('hid');
            $type=I('get.type');
            $data=$user->where ('id='.$id)->find ();
            $this->assign ('data',$data);
            
            $this->assign('type',$type);
            $this->display ('pay/weixin');
        }
    
        public function weixingai(){
            $id=session('hid');
            $user=M('user');
            $data=$user->where ('id='.$id)->find ();
            $this->assign ('data',$data);
            $this->display ('pay/wxgai');
        }
        public function weixingais(){
            $data=I('post.');
            $user=M('user');
            $id=session('hid');
            $name=$user->where("weixin='".$data['weixin']."'")->find();
            if ($name){
                return $this->ajaxReturn (array('code'=>0,'msg'=>'不可与当前微信号重复'));
            }
            $ty=$user->where('id='.$id)->save($data);
            if ($ty){
                return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U('payconfig/diswexin')));
            }
        }
        public function wxpays(){
            $value=I('post.');
            $id=session ('hid');
            $user=M('user');
            $tixian=M('tixian');
            $data=$user->where ('id='.$id)->find ();
            if (empty(trim($data['weixin']))){
                $this->ajaxReturn (array ('code'=>0,'msg'=>'请设置微信账号'));
            }
            $dat['type']=$value['type'];
            if ($dat['type']==2){
                $data['available_balance']=(float)$data['available_balance']-(float)$value['money'];
            }elseif($dat['type']==1){
                $data['guaranty']=(float)$data['guaranty']-(float)$value['money'];
            }
            
            $as=$user->where ('id='.$id)->save ($data);
            
            if ($as){
                $msg['zhanghu']=$data['weixin'];
               
                $msg['zhanghuname']=$data['weixinname'];
                
                $msg['leixing']=2;
                $msg['time']=time();
                $msg['status']=0;
                $msg['price']=$value['money']*((100-C('cash_fei'))/100);
                $msg['user_id']=$id;
                $msg['type']=$value['type'];
                
                $tixian=$tixian->add($msg);
                if($tixian){
                    getAccount($id,time(),$value['money'],3,1);
                    $this->ajaxReturn (array ('code'=>1,'msg'=>'提现申请已提交，将在7个工作日内到账','url'=>U('qianbao/index',array ('type'=>$value['type']))));
                }
            
            }
        }
        public function mingxis(){
            $user=M('tixian');
            $id=session('hid');
            
            $data=$user->where('user_id='.$id)->order('time desc')->select();
           
            $this->assign('data',$data);
            $this->display('pay/mingxi');
        }
        public function tixians(){
            $this->display('tixian/tixians');
        }
        
    
    
    
    }