<?php
namespace app\index\controller;
use app\common\model\Centre;
use think\Request;                  // 引用Request
use think\Controller;

class CentreController extends Controller
{
	public function index()
	{    
		// // 获取查询信息
		// $name = Request::instance()->get('content');

		// // 实例化F
		// $Centre = new Centre;

		// // 定制查询信息
		// if (!empty($name)) {
		// 	$Centre->where('name', 'like', '%' . $name . '%');
		// }

		// $centres = Centre::paginate(5);
		// $this->assign('centres', $centres);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Centre = new Centre;

		// 设置默认值
		$Centre->id = 0;
		$Centre->content = '';

		$this->assign('Centre', $Centre);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Centre = new Centre;
       
        // 新增数据
        if (!$this->saveCentre($Centre)) {
            return $this->error('操作失败' . $Centre->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Centre = Centre::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Centre', $Centre);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Centre = Centre::get($id);
        if (is_null($Centre)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveCentre($Centre)) {
            return $this->error('操作失败' . $Centre->getError());
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
		$Centre = Centre::get($id);

		// 要删除的对象不存在
		if (is_null($Centre)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Centre->delete()) {
			return $this->error('删除失败:' . $Centre->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Centre                  &$Centre 中心组织机构
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveCentre(Centre &$Centre) 
    {
        // 写入要更新的数据
        $Centre->content = Request::instance()->post('content');

        // 更新或保存
        return $Centre->validate()->save();
    }
}