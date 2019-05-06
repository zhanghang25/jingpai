<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/3/28
     * Time: 14:18
     */
    namespace Home\Controller;
    use Vendor\Page;
    class AddressController extends ComController{
        public function _initialize ()
        {
            parent::_initialize();
            if (!session('hid')){
                $this->display('User/login');
                exit;
        
            }
        }
        public function lists(){
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
                    $address->where('id='.$datq['id'])->save(array('default'=>1));
                }
            }
            $data=$user->where ('uid='.session('hid'))->order ('id asc')->select();
            if (!$data){
                $data=array();
            }
            $this->assign ('data',$data);
            $this->display ('Personal/address');
        }
        public function edits(){
            $data=I('get.');
            $address=M('address');
            $address=$address->where('id='.$data['edg'])->find();
            $this->assign('address',$address);
         return $this->display ('Personal/editaddress');
        }
        public function postedit(){
            $data=I('post.');
            
            $date=array();
            $string=explode (',',$data['city']);
            $date['province']=$string[0];
            $date['name']=$data['name'];
            $date['city']=$string[1];
            $date['county']=$string[2];
            $date['detailed']=$data['detailed'];
            $date['phone']=$data['phone'];
            $address=M('address');
            $s=$address->where ('id='.$data['id'])->field('id','city','name','province','county','detailed','phone')->find();
            $u=$address->where ('id='.$data['id'])->save($date);
            if (array_diff_assoc($s,$data) ){
                return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U ('address/lists')));
            }
            if ($u){
                return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U ('address/lists')));
            }else{
                return $this->ajaxReturn (array ('code'=>0,'msg'=>'修改失败'));
            }
        }
        public function adds(){
             
              $this->display ('Personal/addaddress');
        }
        public function addpost(){
            $data=I('post.');
            $user=M('address');
            $date=array();
            $date['uid']=session('hid');
            $io=$user->where('uid='.session('hid'))->find();
            if ($io){
              $date['default']=0;
            }
            $string=explode (',',$data['city']);
            $date['province']=$string[0];
            $date['name']=$data['name'];
            $date['city']=$string[1];
            $date['county']=$string[2];
            $date['detailed']=$data['detailed'];
            $date['phone']=$data['phone'];
            $uu=$user->add($date);
            if ($uu){
                $this->ajaxReturn (array ('code'=>1,'msg'=>'添加收货地址成功','url'=>U('address/lists')));
            }else{
                $this->ajaxReturn (array ('code'=>0,'msg'=>'添加收货地址失败'));
            }
        }
        public function defaults(){
            $data=I('post.');
            $address=M('address');
            $date=$address->where('id='.$data['address_id'])->find();
            $count=$address->where('uid='.$date['uid'])->count();
            if ($count<=1){
                if ($date['default']==0){
                   $address->where('uid='.$date['uid'])->save(array('default'=>1));
                }
                $this->ajaxReturn (array ('code'=>200));
            }
            $map=array();
            $map['uid']=array('eq',$date['uid']);
            $map['default']=array('eq',1);
            $b=$address->where($map)->find();
             if ($b){
                $d=$address->where('uid='.$date['uid'])->save(array('default'=>0));
            }else{
                $d=true;
            }
           
            if ($d){
                $c=$address->where ('id='.$data['address_id'])->save(array('default'=>1));
                if ($c){
                    $this->ajaxReturn (array ('code'=>200));
                }else{
                    $this->ajaxReturn (array ('code'=>300));
                }
            }
            
            
        }
        public function  delet(){
           $data=I('post.');
           $address=M('address');
           $date=$address->where ('id='.$data['address_id'])->find();
           $del=$address->where ('id='.$data['address_id'])->delete();
           
           if ($del){
               if ($date['default']==1){
                   $uid=$address->where('uid='.$date['uid'])->find();
                  
                   if ($uid){
                       $u=$address->where ('id='.$uid['id'])->save (array ('default'=>1));
                   }
                 $this->ajaxReturn (array ('code'=>200,'msg'=>'删除成功'));
               }else{
                   $this->ajaxReturn (array ('code'=>200,'msg'=>'删除成功'));
               }
           }else{
              $this->ajaxReturn (array ('code'=>0,'msg'=>'删除失败'));
           }
        }
    }