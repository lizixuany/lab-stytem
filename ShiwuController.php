<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Index;

class ShiwuController extends Controller
{
    public function index()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function shiwu1()
    {
        $Shiwu1 = new $Shiwu1;
        var_dump($Shiwu); 
        // $htmls = $this->fetch();

        // return $htmls;
    }

}