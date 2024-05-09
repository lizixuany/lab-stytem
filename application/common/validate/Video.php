<?php
namespace app\common\validate;
use think\Validate;

class Notice extends Validate
{
    protected $rule = [
        'content'  => 'require',
        'location' => 'require',
        'creat_time'  => 'require'     
    ];
}