<?php
namespace app\common\validate;
use think\Validate;

class Newsletters extends Validate
{
    protected $rule = [
        'content'  => 'require',
        'creat_time'  => 'require'     
    ];
}
