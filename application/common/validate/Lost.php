<?php
namespace app\common\validate;
use think\Validate;

class Lost extends Validate
{
    protected $rule = [
        'name'  => 'require',
        'place'  => 'require',
        'location'  => 'require',
        'state'  => 'require'       
    ];
}