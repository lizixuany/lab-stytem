<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

/**
 * Notice 公告通知信息表
 */
class Notice extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_notice';

    //获取新闻列表
    public function getList(){
        return $this->field('id,title,content,create_time')->order('id','desc')->select();
    }
}