<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

class Video extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_video';

    //获取新闻列表
    public function getList(){
        return $this->field('id,content,create_time,location')->order('id','desc')->select();
    }
}