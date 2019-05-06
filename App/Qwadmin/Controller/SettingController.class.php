<?php
/**
 *
 * 版权所有：素材火<qwadmin.sucaihuo.com>
 * 作    者：素材水<hanchuan@sucaihuo.com>
 * 日    期：2016-01-20
 * 版    本：1.0.0
 * 功能说明：网站设置控制器。
 *
 **/

namespace Qwadmin\Controller;

class SettingController extends ComController
{
    public function setting()
    {

        $vars = M('setting')->where('type=1')->select();
        $this->assign('vars', $vars);

        $this->display();
    }

    public function update()
    {

        $data = $_POST;
        $data['sitename'] = isset($_POST['sitename']) ? strip_tags($_POST['sitename']) : '';
        $data['title'] = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
        $data['keywords'] = isset($_POST['keywords']) ? strip_tags($_POST['keywords']) : '';
        $data['description'] = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
        $data['footer'] = isset($_POST['footer']) ? $_POST['footer'] : '';
        $Model = M('setting');
        foreach ($data as $k => $v) {
            $Model->data(array('v' => $v))->where("k='{$k}'")->save();
        }
        //清除旧的缓存数据
        $cache = \Think\Cache::getInstance();
        $cache->clear();
        addlog('修改网站配置。');
        $this->success('恭喜，网站配置成功！');
    }

    public function save()
    {
        if(!IS_POST)    $this->error('数据来源错误');
        $config = I('post.');
        $filename = I('post.filename');
        unset($config['filename']);
        $data = '<?php return array(';
        foreach($config as $k=>$v){
            $data .= "'$k' => '$v',";
        }
        $data .= ');';
        $file = @fopen(CONFIG_PATH.$filename.'.php','w');
        $result = fwrite($file,$data);
        if($file)   @fclose($file);
        if($result){
            $this->success('保存成功');
        }else{
            $this->error('保存失败');
        }
    }
}