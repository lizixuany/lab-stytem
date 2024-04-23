<?php
namespace app\common\validate;
use think\Validate;

class Centre extends Validate
{
    protected $rule = [
        'content'  => 'require'     
    ];
}
