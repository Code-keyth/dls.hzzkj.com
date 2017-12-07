<?php
/**
 * Created by PhpStorm.
 * User: FX55
 * Date: 17.10.1
 * Time: 9:37
 */

namespace app\common\model;
use think\Model;

class Goodtype extends Model
{
    static function type_add_up(){
        $goodtype = new Goodtype();
        $goodtype->name = '';
        $goodtype->describe = '';
        $goodtype->price = '';
        return $goodtype;
    }

}