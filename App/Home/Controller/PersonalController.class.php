<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/3/27
     * Time: 15:31
     */
    namespace Home\Controller;
    use Vendor\Page;
    class  PersonalController extends ComController{
        public function _initialize()
        {
            parent::_initialize();
          if (!session('hid')){
              $this->display('User/login');
              exit;
              
          }
        }
        public function setup(){
            $id=I('get.id');
            $set=M('category');
            $article=M('article');
            $data=$set->where ('dir='.$id)->find ();
            if ($data){
                $data1=$article->where ('sid='.$data['id'])->select ();
            }
            if (!$data1){
                $data1=array();
            }
            $this->assign('data',$data1);
        
            return $this->display('User/setup');
        }
        public function info(){
            $user=M('user');
            $data=$user->where('id='.session('hid'))->find();
            
            $this->assign ('data',$data);
            return $this->display('User/info');
        }
        public function mgai(){
            $user=M('user');
            $data=$user->where('id='.session('hid'))->find ();
            $this->assign ('data',$data);
            return $this->display('User/mgai');
        }
        public function  editName(){
            $data=I('post.');
            $user=M('user');
            $id=session('hid');
            $name=$user->where("name='".$data['name']."'")->find();
            if ($name){
                return $this->ajaxReturn (array('code'=>0,'msg'=>'该用户名已被占用,请重新填写'));
            }
            $ty=$user->where('id='.$id)->save($data);
            if ($ty){
                return $this->ajaxReturn (array ('code'=>1,'msg'=>'修改成功','url'=>U('personal/info')));
            }
        }
            public function img(){
                  $file=$_FILES['avatar'];
                if($file && $file['error'] == 0){
                    
                    //实例化文件上传类
                    //自定义配置数据
                    $config = array(
                        'maxSize'       => 0, //上传的文件大小限制 (0-不做限制) byte
                        'exts'          =>  array('jpg', 'png', 'gif', 'jpeg'), //允许上传的文件后缀
                        'rootPath'      =>  ROOT_PATH . UPLOAD_PATH, //保存根路径
                    );
                    $upload = new \Think\Upload($config);
                    $upload_res = $upload -> uploadOne($file);
                    // dump($upload_res);die;
                    if(!$upload_res){
                        //上传失败，获取错误信息
                        $error = $upload -> getError();
                        //将上传类的错误信息，记录到模型类上error属性上
                        $this -> error = $error;
                        return false;
                    }
                    //上传成功，需要拼接文件保存路径，用于添加到数据表
                    $data['goods_big_img'] = UPLOAD_PATH . $upload_res['savepath'] . $upload_res['savename'];
                    $b=UPLOAD_PATH . $upload_res['savepath'] . $upload_res['savename'];
                    $image = new \Think\Image();
                   
                    
                    $image->open($_SERVER['DOCUMENT_ROOT'].$b);
                    $ty=UPLOAD_PATH . $upload_res['savepath'] .'mini_'. $upload_res['savename'];
                    $image->thumb(150, 150)->save($_SERVER['DOCUMENT_ROOT'].$ty);
                    //商品logo图片上传成功，生成缩略图
                    @unlink ($_SERVER['DOCUMENT_ROOT'].$b);
                    $ty=UPLOAD_PATH . $upload_res['savepath'] .'mini_'. $upload_res['savename'];
                   
                    
                    //数据处理成功，返回新的$data
                    $date['thumb']=$ty;
                    $user=M('user');
                    $b=$user->where('id='.session('hid'))->find();
                    $a=$user->where ('id='.session ('hid'))->save($date);
                    if ($a){
                        
                        if ($b['thumb']){
                            $L=$_SERVER['DOCUMENT_ROOT'].$b['thumb'];
                            unlink($_SERVER['DOCUMENT_ROOT'].$b['thumb']);
                            $this->ajaxReturn(array ('code'=>1,'msg'=>$L));
                        }
                        
                        
                    }
                   
                }else{
                    return $this->ajaxReturn (array ('code'=>0,'msg'=>$file['name']));
                }

            }
            public function service(){
             return $this->display('Personal/4');
            }
          
       
        
        
    }