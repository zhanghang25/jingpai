<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/3/29
     * Time: 14:42
     */
    namespace Qwadmin\Controller;
    use Qwadmin\Controller\ComController;
    class IntegralController extends ComController{
        public function index(){
            $data=M('integral');
            $data=$data->select ();
            $this->assign ('data',$data);
            
            return $this->display();
        }
        public function add(){
            return $this->display();
        }
        public function doadd(){
            $data=I ('post.');
            
            unset($data['aid']);
            $data['addtime']=time ();
           
            $integral=M('integral');
            $f=$integral->add ($data);
            if ($f){
                $this->success ('商品添加成功，即将返回添加商品页面');
            }else{
                $this->error ('商品添加失败');
            }
            
        }
        public function edit(){
            $id=I('get.aid');
            $integral=M('integral');
            $data=$integral->where ('id='.$id)->find ();
           /* $data['detail']= htmlspecialchars_decode($data['detail']);*/
           
            $this->assign ('data',$data);
            $this->display ();
        }
        public function doedit(){
         $data=I('post.');
         
         $id=$data['aid'];
         unset($data['aid']);
        $data['addtime']=time ();
        $integral=M('integral');
        $f=$integral->where('id='.$id)->save($data);
        if ($f){
            $this->success ('商品修改成功，即将返回添加商品页面');
        }else{
            $this->error ('商品修改失败');
        }
       }
       public function del(){
       $id=I('param.ids');
       $integral=M('integral');
      
       if (is_array ($id)){
          foreach($id as $v){
              $img=$integral->where ('id='.$v)->find ();
              
             $integral->where ('id='.$v)->delete();
             if ($integral){
                 unlink($_SERVER['DOCUMENT_ROOT'].$data['thumbnail']);
             }
          }
           $this->success('删除成功');
       }else{
           $img=$integral->where ('id='.$id)->find ();
       $del=$integral->where ('id='.$id)->delete();
       if ($del){
           unlink($_SERVER['DOCUMENT_ROOT'].$data['thumbnail']);
           $this->success('删除成功');
       }else{
           $this->error('删除失败');
       }
       }
       }
       public function sel(){
            $data=I('get.');
            $integral=M('integral');
            $data=$integral->where("name like '%".$data['keyword']."%'")->order('addtime '.$data['order'])->select();
          
            $this->assign('data',$data);
            $this->display('integral/index',$data);
       
       }
       
       public function mingxi(){
            $jifen=M('jifen');
            $user=M('user');
    
           $p = intval($p) > 0 ? $p : 1;
    
         
           $pagesize = 15  ;#每页数量
           $offset = $pagesize * ($p - 1);//计算记录偏移量
           $prefix = C('DB_PREFIX');
//        $sid = isset($_GET['sid']) ? $_GET['sid'] : '';
    
           $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
           $where = '1 = 1 ';
//        if ($sid) {
//            $sids_array = category_get_sons($sid);
//            $sids = implode(',',$sids_array);
//            $where .= "and {$prefix}auction_info.sid in ($sids) ";
//        }
           
           //默认按照时间降序
           $orderby = "time desc";
           if ($order == "asc") {
        
               $orderby = "time asc";
           }
    
    
    
           $count = $jifen->where($where)->count();
        
    
           $page = new \Think\Page($count, $pagesize);
           $page = $page->show();
            $data=$jifen->where($where)->order($orderby)->limit($offset . ',' . $pagesize)->select();;
            foreach ($data as $k=>$v){
                $data[$k]['uid']=$user->where('id='.$v['uid'])->find()['name'];
            }
            $this->assign('data',$data);
           $this->assign('page',$page);
           $this->display();
       }
       
    }