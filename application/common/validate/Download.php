<?php
namespace app\common\validate;
use think\Validate;

class Download extends Validate
{
    protected $rule = [
        'content'  => 'require',
        'location' => 'requite',
        'creat_time'  => 'require'     
    ];
}
