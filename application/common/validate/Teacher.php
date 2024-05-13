<?php
namespace app\common\validate;
use think\Validate;

class Teacher extends Validate
{
    protected $rule = [
        'name' => 'require',  
        'content'  => 'require',
        'study' => 'require',
        'success' => 'require'
    ];
}
