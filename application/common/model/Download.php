<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

/**
 * Download 下载信息表
 */
class Download extends Model
{
    //指定数组表名
    protected $table = 'yunzhi_download';

    //获取新闻列表
    public function getList(){
        return $this->field('id,content,create_time,location')->order('id','desc')->select();
    }

}