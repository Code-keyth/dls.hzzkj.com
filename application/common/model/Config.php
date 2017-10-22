<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 17-10-20
 * Time: 下午5:06
 */

namespace app\common\model;

use think\Model;

class Config extends Model{

    static function config_save($data){
        $Config=new Config();

        $list = [
            ['id'=>'5','value'=>$data['icp']],
            ['id'=>'4','value'=>$data['footer_info']],
            ['id'=>'3','value'=>$data['site_description']],
            ['id'=>'2','value'=>$data['site_keyword']],
            ['id'=>'1','value'=>$data['site_title']]];
        $save=$Config->saveAll($list);



        if($save)
            return true;
        return false;

    }

}