<?php
namespace app\common\validate;
use think\Validate;

class Image extends Validate
{
    protected $rule = [
        'title'  => 'require',
        'content'  => 'require'
    ];
}
