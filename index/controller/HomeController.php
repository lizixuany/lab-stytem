<?php
namespace app\index\controller;
use think\Db;
use think\Controller;   // 用于与V层进行数据传递


class HomeController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
