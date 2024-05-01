<?php
namespace app\index\controller;
use app\common\model\Notice;
use think\Request;                  // 引用Request
use think\Controller;

class NoticeController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$content = Request::instance()->get('content');

		// 实例化F
		$Notice = new Notice;

		// 定制查询信息
		if (!empty($content)) {
			$Notice->where('content', 'like', '%' . $content . '%');
		}

		$notices = Notice::paginate(5);
		$this->assign('notices', $notices);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Notice = new Notice;

		// 设置默认值
		$Notice->id = 0;
		$Notice->title = '';
		$Notice->content = '';
		$Notice->create_time = '0';

		$this->assign('Notice', $Notice);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Notice = new Notice;
       
        // 新增数据
        if (!$this->saveNotice($Notice)) {
            return $this->error('操作失败' . $Notice->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Notice = Notice::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Notice', $Notice);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Notice = Notice::get($id);
        if (is_null($Notice)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveNotice($Notice)) {
            return $this->error('操作失败' . $Notice->getError());
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
		$Notice = Notice::get($id);

		// 要删除的对象不存在
		if (is_null($Notice)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Notice->delete()) {
			return $this->error('删除失败:' . $Notice->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Notice                  &$Notice 公告通知
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveNotice(Notice &$Notice) 
    {
        // 写入要更新的数据
		$Notice->title = Request::instance()->post('title');
        $Notice->content = Request::instance()->post('content');
		$Notice->create_time = Request::instance()->post('create_time');

        // 更新或保存
        return $Notice->validate()->save();
    }

	public function index2(){
		//公告通知
        //获取数据
        $notice= new Notice();
        $noticeList = $notice->getList();

        //传递给首页模板
        $this->assign('noticeList',$noticeList);

		//渲染首页模板
        return $this->fetch();
	}
}