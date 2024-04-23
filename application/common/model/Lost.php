<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

/**
 * Lost 失物招领信息表
 */
class Lost extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_lost';

    //获取新闻列表
    public function getList(){
        return $this->field('id,name')->order('id','desc')->select();
    }
}