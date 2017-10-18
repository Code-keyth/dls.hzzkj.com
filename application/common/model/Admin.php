<?php
/**
 * Created by PhpStorm.
 * User: FX55
 * Date: 17.10.1
 * Time: 9:37
 */

namespace app\common\model;
use think\Cookie;
use think\Model;
use think\Request;

class Admin extends Model
{
    public function getUpdataTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
    static function CheckAdmin($name,$pw,$online){
        $Admin=NEW Admin();
        $pw=self::pw($pw);
       $save=$Admin->where('username|mobile|email',$name)->where('passwd',$pw)->select();
        if($save){
            self::login_cookie($save[0],$online);
            return true;
        }
        return false;
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
            $time=604800;

        }
        Cookie::set('HZZ_USER',$cookie,$time);
        $user->cookie=$cookie;
        $user->save();
    }
}