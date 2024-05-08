<?php
namespace app\index\controller;
use app\common\model\Download;
use think\Request;                  // 引用Request
use think\Controller;

class DownloadController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$content = Request::instance()->get('content');

		// 实例化F
		$Download = new Download;

		// 定制查询信息
		if (!empty($content)) {
			$Download->where('content', 'like', '%' . $content . '%');
		}

		$downloads = Download::paginate(5);
		$this->assign('downloads', $downloads);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Download = new Download;

		// 设置默认值
		$Download->id = 0;
		$Download->content = '';
		$Download->create_time = '';
		$Download->location = '';

		$this->assign('Download', $Download);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Download = new Download;
       
        // 新增数据
        if (!$this->saveDownload($Download)) {
            return $this->error('操作失败' . $Download->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Download = Download::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Download', $Download);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Download = Download::get($id);
        if (is_null($Download)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveDownload($Download)) {
            return $this->error('操作失败' . $Download->getError());
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
		$Download = Download::get($id);

		// 要删除的对象不存在
		if (is_null($Download)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Download->delete()) {
			return $this->error('删除失败:' . $Download->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Download                  &$Download 资料下载
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveDownload(Download &$Download) 
    {
        // 写入要更新的数据
        $Download->content = Request::instance()->post('content');
		$Download->create_time = Request::instance()->post('create_time');

        // 更新或保存
        return $Download->validate()->save();
    }

	public function upload(){
		// 获取表单上传文件 例如：1.png
		$file = request()->file('image');

		// 移动到框架应用根目录/public/Download/ 目录下
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'Download','');
			
			if($info){
				// 成功上传后 获取上传信息
				// a902d02fae5cdd89f86aacc71730ac15.png
				$filename = $info->getFilename(); 

				// 实例化请求信息
				$Request = Request::instance();
				$id = Request::instance()->param('id/d');

				// 判断是否存在当前记录
				if (is_null($Download = Download::get($id))) {
					return $this->error('未找到ID为' . $id . '的记录');
				}
				$location = '/thinkphp5/public/Download/' . "$filename";
				$Download->location = $location;
		
				// 添加数据
				if (!$Download->validate(true)->save()) {
					return $this->error('数据添加错误：' . $Download->getError());
				}
		
				return $this->success('操作成功');
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
	}

	public function index2(){
		$pageSize = 5; //每页显示5条数据

		//资料下载
        //获取数据
        $download= new Download();
        $downloadList = $download->getList();

		//调用分页
		$downloadList = $download->paginate($pageSize);

        //传递给首页模板
        $this->assign('downloadList',$downloadList);

		//渲染首页模板
        return $this->fetch();
	}
}