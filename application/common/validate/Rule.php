<?php
namespace app\common\validate;
use think\Validate;

class Rule extends Validate
{
    protected $rule = [
        'name' => 'requite',
        'content'  => 'require'     
    ];
}
