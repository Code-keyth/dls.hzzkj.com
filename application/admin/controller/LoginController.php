<?php
/**
 * Created by PhpStorm.
 * User: FX55
 * Date: 17.10.3
 * Time: 20:36
 */
namespace app\admin\controller;
use app\common\model\Admin;
use app\common\model\Member;
use think\Controller;
use think\Cookie;
use think\Request;

class LoginController extends Controller{
    public function index(){
        $cookie=cookie('HZZ_USER');
        $aaa10=NEW Admin();
        if(!is_null($cookie)){
            $aaa10=$aaa10->where('cookie',$cookie)->find();
            if($aaa10){
                $this->error('请不要重复登录！',url('index/index'));
            }
        }
        return $this->fetch();
    }
    public function login(){

        $postdata=Request::instance()->post();
        $username=$postdata['username'];
        $password=$postdata['password'];
        $online=0;
        if(isset($postdata['online'])){
        $online=$postdata['online'];}
        $captcha = input('verify');
        if(!captcha_check($captcha)){
            //验证码错误
            return alert('验证码错误',url('login/index'),5,0);
        }
        $state=Admin::CheckAdmin($username,$password,$online);
        if(!$state){
            return alert('登陆失败！',url('login/index'),5,0);
        };
        return alert('登陆成功！',url('index/index'),6,0);

    }
    public function Logout(){
        $Admin=NEW Admin();
        $Admin=$Admin->where('cookie',cookie('HZZ_USER'))->find();
        $Admin->state=0;
        $Admin->cookie=null;
        $Admin->save();
        Cookie::delete('HZZ_USER');
        return alert('退出成功！',url('index'),6,0);
    }
    public function member_validate(){
        $data=Request::instance()->get('data');
        $save=Member::register_validate($data);
        if($save){return false;}
        return true;
    }

}