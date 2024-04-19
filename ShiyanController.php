<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Index;

class ShiyanController extends Controller
{
    public function changsuo()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function chuangxin()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function linian()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function shipin()
    {
        $htmls = $this->fetch();

        return $htmls;
    }
}