<?php
namespace app\common\validate;
use think\Validate;

class Download extends Validate
{
    protected $rule = [
        'location' => 'requite',
        'content'  => 'require',
        'create_time'  => 'require'     
    ];
}
