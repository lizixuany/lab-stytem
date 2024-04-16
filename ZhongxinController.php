<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Index;

class ZhongxinController extends Controller
{
    public function jianjie()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function shizi()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function jigou()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function guizhang()
    {
        $htmls = $this->fetch();

        return $htmls;
    }
}