<?php

/**
 * Created by PhpStorm.
 * User: FX55
 * Date: 17.10.1
 * Time: 9:34
 */
namespace app\common\model;
use think\Cookie;
use think\Model;
use think\Request;

class Member extends Model
{
    static function CheckMember($name,$pw,$online){
        $Member=NEW Member();
        $pw=self::pw($pw);
        $save=$Member->where('username|mobile|email',$name)->where('passwd',$pw)->select();
        if($save){self::login_cookie($save[0],$online);return true;}return false;}
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d ', $value);
    }

    public function getUpdataTimeAttr($value)
    {
        return date('Y-m-d ', $value);
    }

    static function pw($pw){
       return sha1(md5($pw.'md5').'sha1');
    }

    static function login_cookie($user,$online){
        $ip=Request::instance()->ip();
        $user->visits_ip1=$user->getdata('visits_ip2');
        $user->visits_ip2=$ip;
        $user->visits_ip1=$user->getdata('visits_ip2');
        $user->state=1;
        $user->updata_time=time();
        $user->visits=$user->getdata('visits')+1;
        //验证登陆唯一性（ip+id+登陆时间戳）。通过存储的cookie获取登陆者信息
        $cookie=md5($ip.$user->getdata('id').time());
        $time=10000;
        if($online==1){
            $time=604800;}
        Cookie::set('HZZ_USER_MEM',$cookie,$time);
        $user->cookie=$cookie;
        $user->save();
    }
    static function get_id(){
        $Member=NEW Member();
        $id=$Member->where("cookie",Cookie::get('HZZ_USER_MEM'))->column('id');
        return $id[0];
    }
    static function integral($getid){
        $Project=NEW Project();
        $sum=$Project->where('state=7')->where('mid',$getid)->sum('price');
        $member=Member::get($getid);
        $member->integral=$sum/10;
        $member->save();
    }
    // 验证会员手机号邮箱用户名是否有重复
    static function register_validate($data){
        $save=self::where('username|mobile|email',$data)->find();
        return $save;
    }
    static function member_add_up(){
        $Member=NEW Member();
        $Member->username = "";
        $Member->mobile = "";
        $Member->email = "";
        $Member->sex = "";
        $Member->city = "";
        $Member->province = "";
        $Member->district = "";
        $Member->annotate = "";
        $Member->street = "";
        return $Member;
    }
    static function member_fapiao(){
        $fapiao['type']="";
        $fapiao['taxnumber']="";
        $fapiao['khh']="";
        $fapiao['khzh']="";
        $fapiao['kpdz']="";
        $fapiao['mobile']="";
        $fapiao['rise']="";
        $fapiao['price']="";
        $fapiao['fpnr']="";
        $fapiao['sjfdz']="";
        $fapiao['sjr']="";
        $fapiao['yzbm']="";
        $fapiao['yldh']="";
        $fapiao['describe']="";
        return $fapiao;
    }


}