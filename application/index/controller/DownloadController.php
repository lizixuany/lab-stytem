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
		$Download->create_time = '0';

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

	public function index2(){
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
}