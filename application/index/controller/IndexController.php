<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
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
        $news = new News();
        $newsList = $news->getList();

        //传递给首页模板
        $this->assign('newsList',$newsList);

        //主要新闻的置顶
        $topNews = array(); // 存储状态为1的数据
        $normalNews = array(); // 存储状态不为1的数据
            
        // 将状态为1的数据置顶
        foreach($newsList as $news) {
            if($news['state'] == 1) {
                $topNews[] = $news;
            } else {
                $normalNews[] = $news;
            }
        }
        
        //将数据传递给首页模板
        $this->assign('topNews',$topNews);
        $this->assign('normalNews',$normalNews);

        //公告通知
        //获取数据
        $notice = new Notice();
        $noticeList = $notice->getList();

        //传递给首页模板
        $this->assign('noticeList',$noticeList);

        //资料下载
        //获取数据
        $download = new Download();
        $downloadList = $download->getList();

        //传递给首页模板
        $this->assign('downloadList',$downloadList);

        //失物招领
        //获取数据
        $lost = new Lost();
        $lostList = $lost->getList();

        //传递给首页模板
        $this->assign('lostList',$lostList);

        //专业实验场所
        //获取数据
        $lab = new Lab();
        $labList = $lab->getList();

        //传递给首页模板
        $this->assign('labList',$labList);

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

        // 查询上一条新闻的ID和标题
        $previousNews = News::where('id', '<', $newsDetail['id'])->order('id', 'desc')->find();
        $previousTitle = $previousNews['title'];

        // 查询下一条新闻的ID和标题
        $nextNews = News::where('id', '>', $newsDetail['id'])->order('id', 'asc')->find();
        $nextTitle = $nextNews['title'];

        // 在视图层传递数据
        return view('news_detail', [
            'newsDetail' => $newsDetail,
            'previousTitle' => $previousTitle,
            'previousNews' => $previousNews,
            'nextNews' => $nextNews,
            'nextTitle' => $nextTitle,
            ]);
    }

    public function noticeDetail($id){
        //根据ID从数据库获取数据详情
        $noticeDetail = Notice::get($id);

        // 查询上一条通知的ID和标题
        $previousNotice = Notice::where('id', '<', $noticeDetail['id'])->order('id', 'desc')->find();
        $previousTitle = $previousNotice['title'];

        // 查询下一条通知的ID和标题
        $nextNotice = Notice::where('id', '>', $noticeDetail['id'])->order('id', 'asc')->find();
        $nextTitle = $nextNotice['title'];

        // 在视图层传递数据
        return view('notice_detail', [
            'noticeDetail' => $noticeDetail,
            'previousTitle' => $previousTitle,
            'previousNotice' => $previousNotice,
            'nextNotice' => $nextNotice,
            'nextTitle' => $nextTitle,
            ]);
    }

    public function downloadDetail($id){
        //根据资料下载ID从数据库获取下载数据详情
        $downloadDetail = Download::get($id);

        // 查询上一条资料下载的ID和标题
        $previousDownload = Download::where('id', '<', $downloadDetail['id'])->order('id', 'desc')->find();
        $previousContent = $previousDownload['content'];

        // 查询下一条资料下载的ID和标题
        $nextDownload = Download::where('id', '>', $downloadDetail['id'])->order('id', 'asc')->find();
        $nextContent = $nextDownload['content'];

        // 在视图层传递数据
        return view('download_detail', [
            'downloadDetail' => $downloadDetail,
            'previousContent' => $previousContent,
            'previousDownload' => $previousDownload,
            'nextDownload' => $nextDownload,
            'nextContent' => $nextContent,
            ]);
    }

    public function lostDetail($id){
        //根据失物招领ID从数据库获取失物招领数据详情
        $lostDetail = Lost::get($id);

        // 查询上一条失物招领的ID和标题
        $previousLost = Lost::where('id', '<', $lostDetail['id'])->order('id', 'desc')->find();
        $previousName = $previousLost['name'];

        // 查询下一条失物招领的ID和标题
        $nextLost = Lost::where('id', '>', $lostDetail['id'])->order('id', 'asc')->find();
        $nextName = $nextLost['name'];

        // 在视图层传递数据
        return view('lost_detail', [
            'lostDetail' => $lostDetail,
            'previousName' => $previousName,
            'previousLost' => $previousLost,
            'nextLost' => $nextLost,
            'nextName' => $nextName,
            ]);
    }

    public function labDetail($id){
        //根据实验场所ID从数据库获取实验场所数据详情
        $labDetail = Lab::get($id);

        // 查询上一条实验场所的ID和标题
        $previousLab = Lab::where('id', '<', $labDetail['id'])->order('id', 'desc')->find();
        $previousName = $previousLab['name'];

        // 查询下一条实验场所的ID和标题
        $nextLab = Lab::where('id', '>', $labDetail['id'])->order('id', 'asc')->find();
        $nextName = $nextLab['name'];

        // 在视图层传递数据
        return view('lab_detail', [
            'labDetail' => $labDetail,
            'previousName' => $previousName,
            'previousLab' => $previousLab,
            'nextLab' => $nextLab,
            'nextName' => $nextName,
            ]);
    }

    public function videoDetail($id){
        //根据视频ID从数据库获取新闻数据详情
        $videoDetail = Video::get($id);

        // 查询上一条视频的ID和标题
        $previousVideo = Video::where('id', '<', $videoDetail['id'])->order('id', 'desc')->find();
        $previousContent = $previousVideo['content'];

        // 查询下一条视频的ID和标题
        $nextVideo = Video::where('id', '>', $videoDetail['id'])->order('id', 'asc')->find();
        $nextContent = $nextVideo['content'];

        // 在视图层传递数据
        return view('video_detail', [
            'videoDetail' => $videoDetail,
            'previousContent' => $previousContent,
            'previousVideo' => $previousVideo,
            'nextVideo' => $nextVideo,
            'nextContent' => $nextContent,
            ]);
    }

    public function teacherDetail($id){
        //根据中心师资ID从数据库获取新闻数据详情
        $teacherDetail = Teacher::get($id);

        // 查询上一条中心师资的ID和标题
        $previousTeacher = Teacher::where('id', '<', $teacherDetail['id'])->order('id', 'desc')->find();
        $previousName = $previousTeacher['name'];

        // 查询下一条中心师资的ID和标题
        $nextTeacher = Teacher::where('id', '>', $teacherDetail['id'])->order('id', 'asc')->find();
        $nextName = $nextTeacher['name'];

        // 在视图层传递数据
        return view('teacher_detail', [
            'teacherDetail' => $teacherDetail,
            'previousName' => $previousName,
            'previousTeacher' => $previousTeacher,
            'nextTeacher' => $nextTeacher,
            'nextName' => $nextName,
            ]);
    }

    public function imagesDetail($id){
        //根据图片新闻ID从数据库获取新闻数据详情
        $imagesDetail = Images::get($id);

        // 查询上一条图片新闻的ID和标题
        $previousImages = Notice::where('id', '<', $imagesDetail['id'])->order('id', 'desc')->find();
        $previousTitle = $previousImages['title'];

        // 查询下一条图片新闻的ID和标题
        $nextImages = Notice::where('id', '>', $imagesDetail['id'])->order('id', 'asc')->find();
        $nextTitle = $nextImages['title'];

        // 在视图层传递数据
        return view('images_detail', [
            'imagesDetail' => $imagesDetail,
            'previousTitle' => $previousTitle,
            'previousImages' => $previousImages,
            'nextImages' => $nextImages,
            'nextTitle' => $nextTitle,
            ]);
    }

    public function imagesDetail($id){
        //根据中心师资ID从数据库获取新闻数据详情
        $imagesDetail = Images::get($id);

        //渲染新闻详情页面
        return $this->fetch('images_detail',['imagesDetail' => $imagesDetail]);
    }
}