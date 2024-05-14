<?php
namespace app\index\controller;
use think\Controller;
use think\DB;
use app\common\model\Index;
use app\common\model\News;
use app\common\model\Notice;
use app\common\model\Download;
use app\common\model\Lost;
use app\common\model\Lab;
use app\common\model\Video;
use app\common\model\Images;
use app\common\model\Teacher;
use app\common\index\LostController;
use app\common\index\ImagesController;

class IndexController extends Controller
{
    public function index()
    {  
        //新闻快讯
        //获取数据
        $news= new News();
        $newsList = $news->getList();

        //传递给首页模板
        $this->assign('newsList',$newsList);

        //公告通知
        //获取数据
        $notice= new Notice();
        $noticeList = $notice->getList();

        //传递给首页模板
        $this->assign('noticeList',$noticeList);

        //资料下载
        //获取数据
        $download= new Download();
        $downloadList = $download->getList();

        //传递给首页模板
        $this->assign('downloadList',$downloadList);

        //失物招领
        //获取数据
        $lost= new Lost();
        $lostList = $lost->getList();

        //传递给首页模板
        $this->assign('lostList',$lostList);

        //专业实验场所
        //获取数据
        $lab= new Lab();
        $labList = $lab->getList();

        //传递给首页模板
        $this->assign('labList',$labList);

        //轮播图片
        //获取数据
        $images= new Images();
        $imagesList = $images->getList();

        //传递给首页模板
        $this->assign('imagesList',$imagesList);

        //轮播图片
        // 实例化F
		$Images = new Images;

        // 获取状态为1的图片数据
        $imageShows = Images::where('state', 1)->select();

        return view('index',['imageShows' => $imageShows]);

        //渲染首页模板
        return $this->fetch();
    }

    public function login()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function index2(){
		// 获取查询信息
		$content = Request::instance()->get('content');

		// 实例化F
		$News = new News;

		// 定制查询信息
		if (!empty($content)) {
			$News->where('content', 'like', '%' . $content . '%');
		}

		$newses = News::paginate(5);
		$this->assign('newses', $newses);

		return $this->fetch();
	}

    public function newsDetail($id){
        //根据新闻ID从数据库获取新闻数据详情
        $newsDetail = News::get($id);

        //渲染新闻详情页面
        return $this->fetch('news_detail',['newsDetail' => $newsDetail]);
    }

    public function noticeDetail($id){
        //根据ID从数据库获取数据详情
        $noticeDetail = Notice::get($id);

        //渲染详情页面
        return $this->fetch('notice_detail',['noticeDetail' => $noticeDetail]);
    }

    public function downloadDetail($id){
        //根据下载ID从数据库获取下载数据详情
        $downloadDetail = Download::get($id);

        //渲染下载详情页面
        return $this->fetch('download_detail',['downloadDetail' => $downloadDetail]);
    }

    public function lostDetail($id){
        //根据失物招领ID从数据库获取失物招领数据详情
        $lostDetail = Lost::get($id);

        //渲染失物招领详情页面
        return $this->fetch('lost_detail',['lostDetail' => $lostDetail]);
    }

    public function labDetail($id){
        //根据实验场所ID从数据库获取实验场所数据详情
        $labDetail = Lab::get($id);

        //渲染实验场所详情页面
        return $this->fetch('lab_detail',['labDetail' => $labDetail]);
    }

    public function videoDetail($id){
        //根据视频ID从数据库获取新闻数据详情
        $videoDetail = Video::get($id);

        //渲染新闻详情页面
        return $this->fetch('video_detail',['videoDetail' => $videoDetail]);
    }

    public function teacherDetail($id){
        //根据中心师资ID从数据库获取新闻数据详情
        $teacherDetail = Teacher::get($id);

        //渲染新闻详情页面
        return $this->fetch('teacher_detail',['teacherDetail' => $teacherDetail]);
    }
}