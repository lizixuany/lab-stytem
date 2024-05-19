<?php
namespace app\common\validate;
use think\Validate;

class Video extends Validate
{
    protected $rule = [
        'content'  => 'require',
        'location' => 'require',
        'create_time'  => 'require'     
    ];
}