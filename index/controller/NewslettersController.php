<?php
namespace app\index\controller;
use app\common\model\Newsletters;
use think\Request;                  // 引用Request
use think\Controller;

class NewslettersController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('content');

		// 实例化F
		$Newsletters = new Newsletters;

		// 定制查询信息
		if (!empty($content)) {
			$Newsletters->where('content', 'like', '%' . $content . '%');
		}

		$newsletterses = Newsletters::paginate(5);
		$this->assign('newsletterses', $newsletterses);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Newsletters = new Newsletters;

		// 设置默认值
		$Newsletters->id = 0;
		$Newsletters->content = '';
		$Newsletters->create_time = '0';

		$this->assign('Newsletters', $Newsletters);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Newsletters = new Newsletters;
       
        // 新增数据
        if (!$this->saveNewsletters($Newsletters)) {
            return $this->error('操作失败' . $Newsletters->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Newsletters = Newsletters::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Newsletters', $Newsletters);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Newsletters = Newsletters::get($id);
        if (is_null($Newsletters)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveNewsletters($Newsletters)) {
            return $this->error('操作失败' . $Newsletters->getError());
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
		$Newsletters = Newsletters::get($id);

		// 要删除的对象不存在
		if (is_null($Newsletters)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Newsletters->delete()) {
			return $this->error('删除失败:' . $Newsletters->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Newsletters                  &$Newsletters 新闻简讯
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveNewsletters(Newsletters &$Newsletters) 
    {
        // 写入要更新的数据
        $Newsletters->content = Request::instance()->post('content');
		$Newsletters->create_time = Request::instance()->post('create_time');

        // 更新或保存
        return $Newsletters->validate()->save();
    }
}