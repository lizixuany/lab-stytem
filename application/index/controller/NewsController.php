<?php
namespace app\index\controller;
use app\common\model\News;
use think\Request;                  // 引用Request
use think\Controller;

class NewsController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$title = Request::instance()->get('title');

		// 实例化F
		$News = new News;

		// 定制查询信息
		if (!empty($title)) {
			$News->where('title', 'like', '%' . $title . '%');
		}

		$newses = News::paginate(5);
		$this->assign('newses', $newses);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$News = new News;

		// 设置默认值
		$News->id = 0;
		$News->title = '';
		$News->content1 = '';
		$News->content2 = '';
		$News->content3 = '';
		$News->image1 = '';
		$News->image2 = '';
		$News->create_time = '0';
		$News->writer = '0';

		$this->assign('News', $News);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $News = new News;
       
        // 新增数据
        if (!$this->saveNews($News)) {
            return $this->error('操作失败' . $News->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($News = News::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('News', $News);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $News = News::get($id);
        if (is_null($News)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveNews($News)) {
            return $this->error('操作失败' . $News->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function delete() {
		// 获取pathinfo传入的ID值.
		$id = Request::instance()->param('id/d');  // “/d”表示将数值转化为“整型”

		if (is_null($id) || 0 === $id) {
			return $this->error('未获取到ID信息');
		}

		// 获取要删除的对象
		$News = News::get($id);

		// 要删除的对象不存在
		if (is_null($News)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$News->delete()) {
			return $this->error('删除失败:' . $News->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    News                  &$News 新闻简讯
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveNews(News &$News) 
    {
        // 写入要更新的数据
		$News->title = Request::instance()->post('title');
        $News->content1 = Request::instance()->post('content1');
		$News->content2 = Request::instance()->post('content2');
		$News->content3 = Request::instance()->post('content3');
		$News->image1 = Request::instance()->post('image1');
		$News->image2 = Request::instance()->post('image2');
		$News->create_time = Request::instance()->post('create_time');
		$News->writer = Request::instance()->post('writer');

        // 更新或保存
        return $News->validate()->save();
    }

	public function index2(){
		$pageSize = 5; //每页显示5条数据

		//新闻快讯
        //获取数据
        $news= new News();
        $newsList = $news->getList();
		
		//调用分页
		$newsList = $news->paginate($pageSize);

		//传递给首页模板
        $this->assign('newsList',$newsList);

		//渲染首页模板
        return $this->fetch();
	}

	public function upload(){
		// 获取表单上传文件 例如：1.png
		$file = request()->file('image');

		// 移动到框架应用根目录/public/image/ 目录下
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'image','');
			
			if($info){
				// 成功上传后 获取上传信息
				// a902d02fae5cdd89f86aacc71730ac15.png
				$filename = $info->getFilename(); 

				// 实例化请求信息
				$Request = Request::instance();
				$id = Request::instance()->param('id/d');

				if (0 !== $id) {
					$News = News::get($id);
				} else {
					$News = new News; 

					$News->id = 0;
					$News->title = '';
					$News->content1 = '';
					$News->content2 = '';
					$News->content3 = '';
				}

				$News->route = '/thinkphp5/public/image/' . "$filename";
					
				// 添加数据
				if (!$News->validate(true)->save()) {
					return $this->error('数据添加错误：' . $News->getError());
				}
		
				$this->assign('News', $News);
				return $this->fetch('edit');
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
	}
}