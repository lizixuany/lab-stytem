<?php
namespace app\index\controller;
use app\common\model\Lost;
use think\Request;                  // 引用Request
use think\Controller;

class LostController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('name');

		// 实例化F
		$Lost = new Lost;

		// 定制查询信息
		if (!empty($name)) {
			$Lost->where('name', 'like', '%' . $name . '%');
		}

		$losts = Lost::paginate(5);
		$this->assign('losts', $losts);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Lost = new Lost;

		// 设置默认值
		$Lost->id = 0;
		$Lost->name = '';
		$Lost->place = '';
		$Lost->location = '';
        $Lost->state = '0';

		$this->assign('Lost', $Lost);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Lost = new Lost;
       
        // 新增数据
        if (!$this->saveLost($Lost)) {
            return $this->error('操作失败' . $Lost->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Lost = Lost::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Lost', $Lost);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Lost = Lost::get($id);
        if (is_null($Lost)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveLost($Lost)) {
            return $this->error('操作失败' . $Lost->getError());
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
		$Lost = Lost::get($id);

		// 要删除的对象不存在
		if (is_null($Lost)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Lost->delete()) {
			return $this->error('删除失败:' . $Lost->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Lost                  &$Lost 失物招领
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveLost(Lost &$Lost) 
    {
        // 写入要更新的数据
        $Lost->name = Request::instance()->post('name');
		$Lost->place = Request::instance()->post('place');
		$Lost->location = Request::instance()->post('location');
		$Lost->state = Request::instance()->post('state');

        // 更新或保存
        return $Lost->validate()->save();
    }

	public function index2(){

		$losts = Lost::paginate(5);
		$this->assign('losts', $losts);

		return $this->fetch();
	}

	public function index3(){

		$losts = Lost::paginate(5);
		$this->assign('losts', $losts);

		return $this->fetch();
	}

	public function download()
    {
    	$download =  new \think\response\Download('image.jpg');
        return $download->name('my.jpg');
        // 或者使用助手函数完成相同的功能
    	// download是系统封装的一个助手函数
        return download('image.jpg', 'my.jpg');
    }


}