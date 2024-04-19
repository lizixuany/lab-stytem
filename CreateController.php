<?php
namespace app\index\controller;
use app\common\model\Create;
use think\Request;                  // 引用Request
use think\Controller;

class CreateController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('content');

		// 实例化F
		$Create = new Create;

		// 定制查询信息
		if (!empty($name)) {
			$Create->where('name', 'like', '%' . $name . '%');
		}

		$creates = Create::paginate(5);
		$this->assign('creates', $creates);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Create = new Create;

		// 设置默认值
		$Create->id = 0;
		$Create->content = '';

		$this->assign('Create', $Create);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Create = new Create;
       
        // 新增数据
        if (!$this->saveCreate($Create)) {
            return $this->error('操作失败' . $Create->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Create = Create::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Create', $Create);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Create = Create::get($id);
        if (is_null($Create)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveCreate($Create)) {
            return $this->error('操作失败' . $Create->getError());
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
		$Create = Create::get($id);

		// 要删除的对象不存在
		if (is_null($Create)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Create->delete()) {
			return $this->error('删除失败:' . $Create->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Create                  &$Create 创新创业
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveCreate(Create &$Create) 
    {
        // 写入要更新的数据
        $Create->content = Request::instance()->post('content');

        // 更新或保存
        return $Create->validate()->save();
    }
}