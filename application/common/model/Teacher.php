<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

class Teacher extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_teacher';

    //获取新闻列表
    public function getList(){
        return $this->field('id,name,content,study,success')->order('id','desc')->select();
    }
}