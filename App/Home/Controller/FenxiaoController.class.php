<?php
    namespace Home\Controller;
    use Vendor\Page;
    class FenxiaoController extends ComController{
        public function _initialize ()
        {
            parent::_initialize();
            if (!session('hid')){
                $this->display('User/login');
                exit;
            
            }
        }
            public function index(){
                $id=session ('hid');
                $user=M('user');
                $page=I('get.page');
                $offct=isset($page)?$page:1;
                if ($offct<1){
                    $offct=1;
                }
                $last=$offct-1;
                if ($last<0){
                    $last=1;
                }
               
                $num=$user->where('parent_id='.$id)->count();
                if (ceil ($num/3)<$offct){
                    $offct1=ceil ($num/3);
                }
                $next=$offct1+1;
                if (ceil ($num/3)<$next){
                    $next=ceil($next);
                }
                   
                    $limit=(($offct-1)*3).",3";
              
                $auction_info=M('auction_info');
                $data=$user->where ('id='.$id)->find();
               
                $code=$user->where('parent_id='.$data['id'])->limit ($limit)->select ();
                
                foreach($code as  $k=>$v){
                    $code[$k]['count']=$auction_info->where ('user_id='.$v['id'])->count();
                }
                $html='';
                if (ceil ($num/3)>0){
                    
                    for ($i=1;$i<=ceil($num/3);$i++){
                       
                       $html.="<a href='".U('fenxiao/index',array('page'=>$i))."' >".$i."</a>";
        
                    }
                }
                
                
                $price=$this->price($id);
                $price=M('user')->where('id='.session('hid'))->find();
                $this->assign('price',$price);
                $this->assign('html',$html);
                $this->assign('num',$num);
                $this->assign('data',$data);
                $this->assign('code',$code);
                return $this->display('Pai/feixiao');
            }
            public function price($uid){
                $acc=M('account');
                $msg=array();
                $msg['user_id']=$uid;
                $data=$acc->where ($msg)->select ();
                $e=0;
                $fen=0;
                foreach($data as $k=>$v){
                    if ($v['type']==7){
                        $e+=(float)$data[$k]['amount'];
                    }elseif ($v['type']==8){
                        $fen+=(float)$data[$k]['amount'];
                    }
                }
                return array('fen'=>$fen,'e'=>$e);
            }
    }