<?php
namespace app\common\validate;
use think\Validate;

class Create extends Validate
{
    protected $rule = [
        'content'  => 'require'     
    ];
}
