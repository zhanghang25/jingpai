<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/3/25
     * Time: 11:16
     */
    namespace Home\Controller;
    use Vendor\Page;
    class UserController extends  ComController{
        public function login(){
            if (session ('hid')){
                $user=M('user');
                $user=$user->where ('id='.session ('hid'))->find();
               
                $this->assign('user',$user);
                $this->display ('User/geren');
                exit;
            }
            $this->display();
        }
        public function dologin(){
           
            $data=I('post.');
            $user=M('user');
            $password=md5(I('post.password').config['salt']);
            $data=$user->where ("phone_num='".$data['mobile']."' and status=1"." and password='".$password."'")->find ();
            
            if ($data){
                
                session('hid',$data['id']);

                $ss=session_id();
                
                $aa=session_name();
                cookie ($aa,$ss,time() + 99 * 365 * 24 * 3600);
               /* setcookie ("PHPSESSID",$data['id'],time() + 99 * 365 * 24 * 3600);*/
                $this->ajaxReturn (array('code'=>1,'msg'=>'登陆成功','url'=>U('home/user/geren')));

            }else{
                $this->ajaxReturn (array('code'=>0,'msg'=>'账号或密码错误请重试'));
            }
        }
           public function geren(){
               if (session ('hid')){
                   $user=M('user');
                   $user=$user->where ('id='.session ('hid'))->find();
                  
                   $this->assign('user',$user);
                   $this->display ('User/geren');
                   exit;
               }
               $this->display('User/login');
           }
            public function sms(){
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
                $phone=I('post.phone');
                $user=M('user');
                $ph=$user->where('phone_num='.$phone)->find();
                if ($ph){
                    return $this->ajaxReturn (array('code'=>800,'msg'=>'手机号已被占用'));
                }
                if (session($phone.'a')&&session($phone.'a')['num']>4){
                    return $this->ajaxReturn (array('code'=>900,'msg'=>'当前手机号发送验证码过多,请稍后重试'));
                }else{
                    $num=1;
                }
                
                $smsapi = "http://www.smsbao.com/"; //短信网关
                $user = "linxipai"; //短信平台帐号
                $sms=rand(10000,99999);
                $pass = md5("linxipai"); //短信平台密码
                $content="【多拍商城】您的验证码为{$sms}，在10分钟内有效";//要发送的短信内容
                $phone = $phone;
                
                $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
                $result =file_get_contents($sendurl) ;
               
                if (!$result){
                       $num=session($phone)['num']+1;
                       session($phone.'a',array('code'=>$sms,'num'=>$num,'time'=>time()+600));
                      return $this->ajaxReturn (array('code'=>1,'msg'=>'发送成功请注意查收'));
              
                }else{
                    return $this->ajaxReturn (array('code'=>0,'msg'=>$statusStr[$result]));
                }
                
                
            }
            public function authentication(){
                $data=I('post.');
                if (!preg_match_all("/^1[34578]\d{9}$/",$data['mobile'])){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'请输入正确的手机号'));
                }
              
                if ($data['code']!=session($data['mobile'].'a')['code']||session($data['mobile'].'a')['time']<time()){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'您的验证码不正确'));
                }
                if (!preg_match_all('/^[a-zA-Z0-9\~\!\@\#\$\%\^\&\*\_\+\{\}\:\"\|\<\>\?\-\=\;\'\,\.\/]{6,15}$/',$data['password'])){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'请输入数字字母特殊符号6-15位'));
                }
                $user=M('user');
                $name=$user->where("name='".$data['name']."'")->find();
                $invite_code=$user->where("invite_code='".$data['invite_code']."'")->find();
                if ($name){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'用户昵称已被占用'));
                }
                if(!trim($data['name'])){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'用户昵称不能为空'));
                }
                if (!trim ($data['invite_code'])){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'邀请码不能为空'));
                }
                
                if (!$invite_code){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'请输入正确的邀请码'));
                }
                
                $lt=array();
                $lt['name']=$data['name'];
                $lt['invite_code']= $this->code();
                $lt['status']=1;
                $lt['parent_id']=$invite_code['id'];
                $lt['create_time']=time();
                $lt['phone_num']=$data['mobile'];
                $lt['ming_password']=I('post.password');
                $lt['password']=md5(I('post.password').config['salt']);
                $io=M('user')->data($lt)->add();
                if ($io){
                    return $this->ajaxReturn (array('code'=>1,'msg'=>'注册成功请稍后','url'=>U('user/login')));
                }else{
                    return $this->ajaxReturn(array('code'=>0,'msg'=>'未知错误'));
                }
            }
            public function edit(){
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
                $phone=I('post.phone');
                $user=M('user');
                $ph=$user->where('phone_num='.$phone)->find();
                if (!$ph){
                    return $this->ajaxReturn (array('code'=>2,'msg'=>'当前手机号未注册'));
                }
                if (session($phone.'a')&&session($phone.'a')['num']>4){
                    return $this->ajaxReturn (array('code'=>900,'msg'=>'当前手机号发送验证码过多,请稍后重试'));
                }else{
                    $num=1;
                }
    
                $smsapi = "http://www.smsbao.com/"; //短信网关
                $user = "linxipai"; //短信平台帐号
                $sms=rand(10000,99999);
                $pass = md5("linxipai"); //短信平台密码
                $content="【多拍商城】您的验证码为{$sms}，在10分钟内有效";//要发送的短信内容
                $phone = $phone;
    
                $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
                $result =file_get_contents($sendurl) ;
    
                if (!$result){
                    $num=session($phone)['num']+1;
                    session($phone.'a',array('code'=>$sms,'num'=>$num,'time'=>time()+600));
                    return $this->ajaxReturn (array('code'=>1,'msg'=>$statusStr[$result]));
                }else{
                    return $this->ajaxReturn (array('code'=>0,'msg'=>$statusStr[$result]));
                }
            }
            public function editpassword(){
            $lt=array();
            $User=M('user');
            $data=I('post.');
                if (!preg_match_all('/^[a-zA-Z0-9\~\!\@\#\$\%\^\&\*\_\+\{\}\:\"\|\<\>\?\-\=\;\'\,\.\/]{6,15}$/',$data['password'])){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'请输入数字字母特殊符号6-15位'));
                }
                if ($data['password']!==$data['upassword']){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'两次密码输入不一致'));
                }
                if ($data['code']!=session($data['mobile'].'a')['code']||session($data['mobile'].'a')['time']<time()){
                    return $this->ajaxReturn (array('code'=>0,'msg'=>'您的验证码不正确'));
                }
                $lt['ming_password']=I('post.password');
                $lt['password']=md5(I('post.password').config['salt']);
                $a=$User->where('phone_num='.$data['mobile'])->save($lt);
                if($a){
                    return $this->ajaxReturn (array('code'=>1,'msg'=>'修改成功请登录','url'=>U('home/user/login')));
                }else{
                    return $this->ajaxReturn (array('code'=>1,'msg'=>'未知错误请重试'));
                }
            }
            public function code(){
               $user=M('user');
                $code=substr(md5(uniqid(microtime(true),true)),1,6);
                $u=$user->where("invite_code='".$code."'")->find ();
                if ($u){
                    $this->code();
                    exit;
                }else{
                    return $code;
                }
            }
            public function layout(){
                   session('hid','0');
                if (!session('hid')){
                    return $this->ajaxReturn(array ('msg'=>'退出成功，请重新登录','code'=>200,'url'=>U('user/login')));
                }else{
                    return $this->ajaxReturn(array('msg'=>'意外错误请重试','code'=>0));
                }
            }
            public function registe(){
               $article=M('article');
               $ac=M('category');
               $data=$ac->where('dir=6')->find();
               $data=$article->where('sid='.$data['id'])->find();
               $str=htmlspecialchars_decode($data['content']);
                $str = trim($str); //清除字符串两边的空格
                //利用php自带的函数清除html格式
                $str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
                $str = preg_replace("/\r\n/","",$str);
                $str = preg_replace("/\r/","",$str);
                $str = preg_replace("/\n/","",$str);
                $str = preg_replace("/ /","",$str);
                $str = preg_replace("/  /","",$str);  //匹配html中的空格
                $str=trim($str);
                $data['content']=$str;
               $this->assign('data',$data);
               $this->display('User/registe');
            }
            
    }