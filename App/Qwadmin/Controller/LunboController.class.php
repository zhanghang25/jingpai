<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/3/29
     * Time: 14:42
     */
    namespace Qwadmin\Controller;
    use Qwadmin\Controller\ComController;
    class LunboController extends ComController
    {
        public function add ()
        {
            return $this->display('Lun/form');
        
        }
        public function update(){
            $data=I('post.');
            $lunbo=M('lunbo');
            $is=$lunbo->add($data);
            if ($is){
                $this->success('添加轮播成功');
            }
            else{
                $this->error('添加轮播失败');
            }
        }
        
        public function index(){
            $lunbo=M('lunbo');
            $lunbotu=$lunbo->order('orders desc')->select();
            $this->assign('lunbo',$lunbotu);
            $this->display('Lun/index');
        }
        
        public function del(){
            $ids=I('param.ids');
         
            $lunbo=M('lunbo');
          
            if (is_array ($ids)){
                foreach ($ids as $k){
                    $lunbo->where('id='.$k)->delete();
                }
                $this->success('删除成功');
            }else{
                $lunbo->where('id='.$ids)->delete();
                $this->success('删除成功');
                
            }
        }
        public function edit(){
            $id=I('get.aid');
            $lunbo=M('lunbo')->where('id='.$id)->find();
            $this->assign('data',$lunbo);
            $this->display('Lun/edit');
        }
        
        public function updates(){
            $data=I('post.');
            
            $id=$data['id'];
            unset($data['id']);
            M('lunbo')->where('id='.$id)->save($data);
            $this->success('修改成功');
        }
    
    }