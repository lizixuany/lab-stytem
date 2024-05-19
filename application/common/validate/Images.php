<?php
namespace app\common\validate;
use think\Validate;

class Images extends Validate
{
    protected $rule = [
        'title'  => 'require',
        'content'  => 'require'
    ];
}
