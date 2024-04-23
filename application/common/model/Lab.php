<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

/**
 * Lab 专业实验室信息表
 */
class Lab extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_lab';

    //获取新闻列表
    public function getList(){
        return $this->field('id,name')->order('id','desc')->select();
    }
}