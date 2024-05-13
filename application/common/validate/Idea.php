<?php
namespace app\common\validate;
use think\Validate;

class Idea extends Validate
{
    protected $rule = [
        'content'  => 'require'     
    ];
}
