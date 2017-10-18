<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 17-10-14
 * Time: 下午3:28
 */
namespace app\common\validate;
use think\Validate;
class Member extends Validate
{
    protected $rule = [
        'username' => 'require|unique:member',
        'mobile' => 'unique:member',
        'email' => 'unique:member',
    ];
    protected $message  =   [
        'username.require' => '名称必须',
        'username.unique' =>'用户名已被占用',
        'email'        => '邮箱已被占用',
    ];
}