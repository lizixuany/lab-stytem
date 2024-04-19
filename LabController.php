<?php
namespace app\index\controller;
use app\common\model\Lab;
use think\Request;                  // 引用Request
use think\Controller;

class LabController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('name');

		// 实例化F
		$Lab = new Lab;

		// 定制查询信息
		if (!empty($name)) {
			$Lab->where('name', 'like', '%' . $name . '%');
		}

		$labs = Lab::paginate(5);
		$this->assign('labs', $labs);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Lab = new Lab;

		// 设置默认值
		$Lab->id = 0;
		$Lab->name = '';
		$Lab->content = '';

		$this->assign('Lab', $Lab);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Lab = new Lab;
       
        // 新增数据
        if (!$this->saveLab($Lab)) {
            return $this->error('操作失败' . $Lab->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Lab = Lab::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Lab', $Lab);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Lab = Lab::get($id);
        if (is_null($Lab)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveLab($Lab)) {
            return $this->error('操作失败' . $Lab->getError());
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
		$Lab = Lab::get($id);

		// 要删除的对象不存在
		if (is_null($Lab)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Lab->delete()) {
			return $this->error('删除失败:' . $Lab->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Lab                  &$Lab 专业实验室
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveLab(Lab &$Lab) 
    {
        // 写入要更新的数据
        $Lab->content = Request::instance()->post('content');
		$Lab->create_time = Request::instance()->post('create_time');

        // 更新或保存
        return $Lab->validate()->save();
    }
}