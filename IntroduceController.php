<?php
namespace app\index\controller;
use app\common\model\Introduce;
use think\Request;                  // 引用Request
use think\Controller;

class IntroduceController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('content');

		// 实例化F
		$Introduce = new Introduce;

		// 定制查询信息
		if (!empty($name)) {
			$Introduce->where('name', 'like', '%' . $name . '%');
		}

		$introduces = Introduce::paginate(5);
		$this->assign('introduces', $introduces);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Introduce = new Introduce;

		// 设置默认值
		$Introduce->id = 0;
		$Introduce->content = '';

		$this->assign('Introduce', $Introduce);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Introduce = new Introduce;
       
        // 新增数据
        if (!$this->saveIntroduce($Introduce)) {
            return $this->error('操作失败' . $Introduce->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Introduce = Introduce::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Introduce', $Introduce);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Introduce = Introduce::get($id);
        if (is_null($Introduce)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveIntroduce($Introduce)) {
            return $this->error('操作失败' . $Introduce->getError());
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
		$Introduce = Introduce::get($id);

		// 要删除的对象不存在
		if (is_null($Introduce)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Introduce->delete()) {
			return $this->error('删除失败:' . $Introduce->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Introduce                  &$Introduce 中心简介
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveIntroduce(Introduce &$Introduce) 
    {
        // 写入要更新的数据
        $Introduce->content = Request::instance()->post('content');

        // 更新或保存
        return $Introduce->validate()->save();
    }
}