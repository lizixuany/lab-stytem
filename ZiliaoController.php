<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Index;

class ZiliaoController extends Controller
{
    public function index()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

}