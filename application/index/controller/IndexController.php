<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Index;
use app\common\index\LostController;

class IndexController extends Controller
{
    public function index()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function login()
    {
        $htmls = $this->fetch();

        return $htmls;
    }
}