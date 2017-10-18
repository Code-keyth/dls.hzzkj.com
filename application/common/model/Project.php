<?php
/**
 * Created by PhpStorm.
 * User: FX55
 * Date: 17.10.1
 * Time: 9:38
 */

namespace app\common\model;
use think\Model;
use app\common\model\Goodtype;
class Project extends Model
{
    public function GoodtypeName($id){
       return Goodtype::get($id);
    }
    public function MemberName($id){
        return Member::get($id);
    }
    public function pro_name($id){
        return Project::get($id)->getdata('name');
    }
    static function pro_add_up(){
        $Project=new Project();
        $Project->name = "";
        $Project->type = "";
        $Project->mid = "";
        $Project->executor="";
        $Project->price = "";
        $Project->describe = "";
        $Project->start_time = "";
        $Project->end_time = "";
        return $Project;
    }

}