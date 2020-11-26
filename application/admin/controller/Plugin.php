<?php
namespace app\admin\controller;
use think\facade\Request;
use think\facade\Env;
class Plugin extends Common{
    public function initialize(){
        parent::initialize();
        //  更新插件
        $this->insertPlugin($this->scanPlugin());
    }
    public function index(){
        if(Request::isAjax()) {
            $list = db('plugin')->select();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1];
        }
        return $this->fetch();
    }
    public function set(){
        $condition['type'] = input('param.type');
        $condition['code'] = input('param.code');
        $model = db('plugin');
        $info = $model->where($condition)->find();
        if(!$info){
            exit($this->error("不存在该插件"));
        }
        $this->assign('title','配置登录插件');
        $info['config'] = unserialize($info['config']);
        $this->assign('info',$info);
        $this->assign('config_value',unserialize($info['config_value']));
        return $this->fetch();
    }
    public function update(){
        $condition['type'] = input('post.type');
        $condition['code'] = input('post.code');
        $model = db('plugin');
        $config = input('post.config/a');
        //空格过滤
        $config = trim_array_element($config);
        if($config){
            $config = serialize($config);
        }

        $row = $model->where($condition)->update(array('config_value'=>$config));
        if($row!==false){
            $result['code'] = 1;
            $result['msg'] = '修改成功!';
        }else{
            $result['code'] = 0;
            $result['msg'] = '修改失败!';
        }
        return $result;

    }
    /**
     * 插件安装卸载
     */
    public function install(){
        $condition['type'] = input('post.type');
        $condition['code'] = input('post.code');
        $update['status'] = input('post.install');
        $model = db('plugin');
        //卸载插件时 删除配置信息
        if($update['status']==0){
            $row = db('plugin')->where($condition)->delete();
        }else{
            $row = $model->where($condition)->update($update);
        }
        if($row){
            $info['code'] = 1;
            $info['url'] = url($condition['type']);
            $info['msg'] = $update['status'] ? '安装成功!' : '卸载成功!';
        }else{
            $info['code'] = 0;
            $info['msg'] = $update['status'] ? '安装失败' : '卸载失败';
        }
        return $info;
    }
    /**
     * 插件目录扫描
     * @return array 返回目录数组
     */
    private function scanPlugin(){
        $plugin_field = array();
        $field = Env::get('root_path')."/plugins";
        $plugin_field = $this->dirscan($field);
        $plugin_list=array();
        foreach($plugin_field as $k=>$v){
            $plugin_list[$v] =  $this->dirscan($field.'/'.$v);
        }
        foreach($plugin_list as $k=>$v){
            foreach($v as $k2=>$v2){
                if(!file_exists(Env::get('root_path').'/plugins/'.$k.'/'.$v2.'/config.php')){
                    unset($plugin_list[$k][$k2]);
                }else {
                    $plugin_list[$k][$v2] = include(Env::get('root_path').'/plugins/'.$k.'/'.$v2.'/config.php');
                    unset($plugin_list[$k][$k2]);
                }
            }
        }
        //dump($plugin_list);
        return $plugin_list;
    }
    /**
     * 获取插件目录列表
     * @param $dir
     * @return array
     */
    private function dirscan($dir){
        $dirArray = array();
        if (false != ($handle = opendir($dir))) {
            $i=0;
            while ( false !== ($file = readdir ( $handle )) ) {
                //去掉"“.”、“..”以及带“.xxx”后缀的文件
                if ($file != "." && $file != ".."&&!strpos($file,".")) {
                    $dirArray[$i]=$file;
                    $i++;
                }
            }
            //关闭句柄
            closedir ( $handle );
        }
        return $dirArray;
    }
    /**
     * 更新插件到数据库
     * @param $plugin_list 本地插件数组
     */
    private function insertPlugin($plugin_list){
        $d_list =  db('plugin')->field('code,type')->select(); // 数据库

        $cv = array();
        $new_arr = array(); // 本地
        //插件类型
        foreach($plugin_list as $pt=>$pv){
            //  本地对比数据库
            foreach($pv as $t=>$v){
                foreach ($v['config'] as $key=>$val){
                    $cv[$val['name']] = $val['value'];
                }
                $tmp['code'] = $v['code'];
                $tmp['type'] = $pt;
                $new_arr[] = $tmp;
                // 对比数据库 本地有 数据库没有
                $is_exit = db('plugin')->where(array('type'=>$pt,'code'=>$v['code']))->find();
                if(empty($is_exit)){
                    $add['code'] = $v['code'];
                    $add['name'] = $v['name'];
                    $add['version'] = $v['version'];
                    $add['icon'] = $v['icon'];
                    $add['author'] = $v['author'];
                    $add['desc'] = $v['desc'];
                    if(isset($v['bank_code'])){
                        $add['bank_code'] = serialize($v['bank_code']);
                    }
                    $add['type'] = $pt;
                    $add['scene'] = $v['scene'];
                    $add['config'] = empty($v['config']) ? '' : serialize($v['config']);
                    $add['config_value'] = empty($cv) ? '' : serialize($cv);
                    db('plugin')->insert($add);
                }
            }
        }
        foreach($d_list as $k=>$v){
            if(!in_array($v,$new_arr)){
                db('plugin')->where($v)->delete();
            }
        }

    }
}