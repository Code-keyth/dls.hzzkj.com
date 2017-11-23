<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 17-10-14
 * Time: 下午12:29
 */

namespace app\index\controller;
use app\common\model\Member;
use think\Controller;
use think\Request;

class LoginController extends Controller
{
    public function register(){
        return $this->fetch();
    }
    public function index(){

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
           # return alert('验证码错误',url('index'),5,0);
        }
        $state=Member::CheckMember($username,$password,$online);
        if(!$state){
            return alert('登陆失败！',url('index'),5,0);
        };
        return alert('登陆成功！',url('admin/index'),6,0);
    }
    public function register_c(){
        $postdata = Request::instance()->post();
        $Member = NEW Member();
        $Member->username = $postdata['username'];
        $Member->mobile = $postdata['mobile'];
        $Member->email = $postdata['email'];
        $Member->passwd =$Member::pw($postdata['password']);
        $Member->city = $postdata['province'] . '-' . $postdata['city'] . '-' . $postdata['district'];
        $Member->street = $postdata['street'];
        $Member->sex = $postdata['sex'];
        $Member->updata_time = time();
        $Member->create_time = time();
        $save = $Member->save();
        if ($save) {
            return alert('会员注册成功！', 'index', 6, 0);
        } else {
            return alert('会员注册失败！'.$Member->getError(), 'index', 5, 0);
        }
    }
    public function Logout(){
        $Admin=NEW Member();
        $Admin=$Admin->where('cookie',cookie('HZZ_USER_MEM'))->find();
        $Admin->state=0;
        $Admin->cookie=null;
        $Admin->save();
        Cookie::delete('HZZ_USER_MEM');
        return alert('退出成功！',url('index'),6,0);
    }

}