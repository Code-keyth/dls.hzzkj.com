<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 17-10-20
 * Time: 下午5:01
 */

namespace app\admin\controller;


use app\common\model\Config;
use think\Controller;
use think\Log;
use think\Request;

class ConfigController extends Controller
{
    /**
     * 系统设置
     **/
    public function index()
    {

        $Config=new Config();
        $configs=$Config->column('value');
        $this->assign('config',$configs);




        return $this->fetch();
    }

    public function index_c()
    {
        $postdata=Request::instance()->post();
        $save=Config::config_save($postdata);
        if ($save)
            return alert('设置成功！','index','6','3');
        return alert('设置失败，请重新尝试！','index','5','3');
    }
    public function log()
    {
        return $this->fetch();
    }

}