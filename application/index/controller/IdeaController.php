<?php
namespace app\index\controller;
use app\common\model\Idea;
use think\Request;                  // 引用Request
use think\Controller;

class IdeaController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('content');

		// 实例化F
		$Idea = new Idea;

		// 定制查询信息
		if (!empty($name)) {
			$Idea->where('name', 'like', '%' . $name . '%');
		}

		$ideas = Idea::paginate(5);
		$this->assign('ideas', $ideas);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Idea = new Idea;

		// 设置默认值
		$Idea->id = 0;
		$Idea->content = '';

		$this->assign('Idea', $Idea);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Idea = new Idea;
       
        // 新增数据
        if (!$this->saveIdea($Idea)) {
            return $this->error('操作失败' . $Idea->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Idea = Idea::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Idea', $Idea);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Idea = Idea::get($id);
        if (is_null($Idea)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveIdea($Idea)) {
            return $this->error('操作失败' . $Idea->getError());
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
		$Idea = Idea::get($id);

		// 要删除的对象不存在
		if (is_null($Idea)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Idea->delete()) {
			return $this->error('删除失败:' . $Idea->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Idea                  &$Idea 实验教学理念
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveIdea(Idea &$Idea) 
    {
        // 写入要更新的数据
        $Idea->content = Request::instance()->post('content');

        // 更新或保存
        return $Idea->validate()->save();
    }

    public function index2(){
        $ideas = Idea::paginate(5);
		$this->assign('ideas', $ideas);

		return $this->fetch();
    }
}