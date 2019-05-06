<?php
    namespace Qwadmin\Controller;
    use Qwadmin\Controller\ComController;
    class TixianController extends ComController{
       public function index(){
           $p=I('get.p');
           $user=M('tixian');
           $keyword1=I('post.keyword1');
           if ($keyword1===''){
               $keyword1=I('get.keyword1');
           }
           $p = intval($p) > 0 ? $p : 1;
           
    
           $pagesize = 15  ;#每页数量
           $offset = $pagesize * ($p - 1);//计算记录偏移量
           $prefix = C('DB_PREFIX');
//        $sid = isset($_GET['sid']) ? $_GET['sid'] : '';
          
           
           $where = '1 = 1 ';
//        if ($sid) {
//            $sids_array = category_get_sons($sid);
//            $sids = implode(',',$sids_array);
//            $where .= "and {$prefix}auction_info.sid in ($sids) ";
//        }
    
           //默认按照时间降序
         
    
    
           $count = $user->where("status='".$keyword1."'")->count();
           $data=$user->select();
           if ($keyword1!==''){
               $data=$user->where("status='".$keyword1."'")->order('time desc')->limit($offset.','.$pagesize)->select();
        
           }else{
               $data=$user->order('time desc')->limit($offset.','.$pagesize)->select();
           }
    
           $page = new \Think\Page($count, $pagesize);
           $page->parameter = array_map('urldecode',array ('keyword1'=>$keyword1));
           $page = $page->show();
          
           
           $io=M('user');
           
           
           
          
           foreach($data as  $k=>$v){
               $data[$k]['user_id']=$io->where('id='.$v['user_id'])->find()['name'];
           }
           $this->assign('page',$page);
           $this->assign('data',$data);
           $this->display('Tixian/index');
       }
       public function del(){
           $id=I('param.ids');
           $user=M('tixian');
           if (is_array($id)){
              foreach($id as $v){
                $u=$user->where('id='.$v)->delete();
                
              }
              $this->success('删除成功');
           }else{
               $u=$user->where('id='.$id)->delete();
              
                   $this->success('删除成功');
               
           }
           
       }
       public function edit(){
           $id=I('get.aid');
           $user=M('user');
           $tixian=M('tixian');
           $data=$tixian->where('id="'.$id.'"')->find();
           $data['user_id']=$user->where('id="'.$data['user_id'].'"')->find()['name'];
           
           $this->assign('data',$data);
           $this->display('Tixian/form');
       }
       public function update(){
           $po=I('post.');
           $id=$po['aid'];
           $user=M('user');
           $tixian=M('tixian');
           unset($po['aid']);
           
           $yu=$tixian->where('id='.$id)->find();
          
           $jo=$tixian->where('id='.$id)->save($po);
           
           if ($po['status']==1){
               $gh=$user->where('id='.$yu['user_id'])->find();
               if ($yu['type']==2){
                   $price=(float)$gh['available_balance']+(float)$yu['price'];
                   $msg['available_balance']=$price;
                   $user->where('id='.$yu['user_id'])->save($msg);
               }elseif($yu['type']==1){
                   $price=(float)$gh['guaranty']+(float)$yu['price'];
                   $msg['guaranty']=$price;
                   $user->where('id='.$yu['user_id'])->save($msg);
               }
              
           }
           $this->success('修改成功');
       }
       
    }