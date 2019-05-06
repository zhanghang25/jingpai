<?php
    /**
     *
     * 版权所有：素材火<qwadmin.sucaihuo.com>
     * 作    者：小马哥<hanchuan@sucaihuo.com>
     * 日    期：2015-09-17
     * 版    本：1.0.3
     * 功能说明：文件上传控制器。
     *
     **/
    
    namespace Qwadmin\Controller;
    
    use Think\Upload;
    
    class UploadController extends ComController
    {
        public function index($type = null)
        {
        
        }
        
        public function uploadpic()
        {
            $Img = I('img');
            $Path = null;
            if ($_FILES['img']) {
                $Img = $this->saveimg($_FILES);
            }
            $BackCall = I('BackCall');
            $Width = I('Width');
            $Height = I('Height');
            if (!$BackCall) {
                $Width = $_POST['BackCall'];
            }
            if (!$Width) {
                $Width = $_POST['Width'];
            }
            if (!$Height) {
                $Width = $_POST['Height'];
            }
            $this->assign('Width', $Width);
            $this->assign('BackCall', $BackCall);
            $this->assign('Img', $Img);
            $this->assign('Height', $Height);
            $this->display('Uploadpic');
        }
        
        private function saveimg($files)
        {
            $mimes = array(
                'image/jpeg',
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/pjpeg',
                'image/gif',
                'image/bmp',
                'image/x-png'
            );
            $exts = array(
                'jpeg',
                'jpg',
                'jpeg',
                'png',
                'pjpeg',
                'gif',
                'bmp',
                'x-png'
            );
            $root=$_SERVER['DOCUMENT_ROOT'].'Public/Uploads/';
            $upload = new Upload(array(
                'maxSize'       => 0, //上传的文件大小限制 (0-不做限制) byte
                'exts'          =>  array('jpg', 'png', 'gif', 'jpeg'), //允许上传的文件后缀
                'rootPath' => $root,
               
            ));
            $info = $upload->upload($files);
            $image = new \Think\Image();
//        echo '<pre>';
//        print_r($_SERVER);
//        echo '</pre>';
//        print_r($info['img']['savepath'].$info['img']['savename']);
//        print_r($info);
//        exit;
            $h=$_SERVER['DOCUMENT_ROOT'].'/Public/Uploads/'.$info['img']['savepath'].$info['img']['savename'];
            $image->open($h);
           
            $image->thumb(640, 640)->save($h);
            if(!$info) {// 上传错误提示错误信息
                $error = $upload->getError();
                echo "<script>alert('{$error}')</script>";
            }else{// 上传成功
                foreach ($info as $item) {
                    $filePath[] = __ROOT__."/Public/Uploads/".$item['savepath'].$item['savename'];
                }
                $ImgStr = implode("|", $filePath);
                return $ImgStr;
            }
        }
        
        public function batchpic()
        {
            $ImgStr = I('Img');
            $ImgStr = trim($ImgStr, '|');
            $Img = array();
            if (strlen($ImgStr) > 1) {
                $Img = explode('|', $ImgStr);
            }
            $Path = null;
            $newImg = array();
            $newImgStr = null;
            if ($_FILES) {
                $newImgStr = $this->saveimg($_FILES);
                if ($newImgStr) {
                    $newImg = explode('|', $newImgStr);
                }
                
            }
            $Img = array_merge($Img,$newImg);
            $ImgStr = implode("|", $Img);
            $BackCall = I('BackCall');
            $Width = I('u');
            $Height = I('Height');
            if (!$BackCall) {
                $Width = $_POST['BackCall'];
            }
            if (!$Width) {
                $Width = $_POST['Width'];
            }
            if (!$Height) {
                $Width = $_POST['Height'];
            }
            $this->assign('Width', $Width);
            $this->assign('BackCall', $BackCall);
            $this->assign('ImgStr', $ImgStr);
            $this->assign('Img', $Img);
            $this->assign('Height', $Height);
            $this->display('Batchpic');
        }
    }
