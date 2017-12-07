<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 17-11-20
 * Time: 下午8:42
 */

namespace app\common\model;
use think\Model;

class Liuyan extends Model
{
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d ', $value);
    }
    public function getUpdataTimeAttr($value)
    {
        return date('Y-m-d ', $value);
    }
}