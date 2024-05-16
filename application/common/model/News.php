<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

/**
 * News 新闻简讯信息表
 */
class News extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_news';

    //获取新闻列表
    public function getList(){
        return $this->field('id,title,content,create_time,state,writer')->order('id','desc')->select();
    }
}