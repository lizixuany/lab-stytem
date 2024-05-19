<?php
namespace app\common\validate;
use think\Validate;

class Notice extends Validate
{
    protected $rule = [
        'title' => 'require',
        'content'  => 'require',
        'create_time'  => 'require'     
    ];
}