<?php
namespace app\common\validate;
use think\Validate;

class Notice extends Validate
{
    protected $rule = [
        'title' => 'require',
        'content'  => 'require',
        'creat_time'  => 'require'     
    ];
}