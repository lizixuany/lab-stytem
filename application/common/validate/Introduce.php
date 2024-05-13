<?php
namespace app\common\validate;
use think\Validate;

class Introduce extends Validate
{
    protected $rule = [
        'content'  => 'require'     
    ];
}
