<?php
namespace app\index\controller;
use app\common\model\Rule;
use think\Request;                  // 引用Request
use think\Controller;

class RuleController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('name');

		// 实例化F
		$Rule = new Rule;

		// 定制查询信息
		if (!empty($name)) {
			$Rule->where('name', 'like', '%' . $name . '%');
		}

		$rules = Rule::paginate(5);
		$this->assign('rules', $rules);

		return $this->fetch();
	}

	public function add() 
	{
		// 实例化
		$Rule = new Rule;

		// 设置默认值
		$Rule->id = 0;
		$Rule->name = '';
		$Rule->content = '';

		$this->assign('Rule', $Rule);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Rule = new Rule;
       
        // 新增数据
        if (!$this->saveRule($Rule)) {
            return $this->error('操作失败' . $Rule->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Rule = Rule::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Rule', $Rule);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的班级信息
        $Rule = Rule::get($id);
        if (is_null($Rule)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveRule($Rule)) {
            return $this->error('操作失败' . $Rule->getError());
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
		$Rule = Rule::get($id);

		// 要删除的对象不存在
		if (is_null($Rule)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Rule->delete()) {
			return $this->error('删除失败:' . $Rule->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     * @param    Rule                  &$Rule 规章制度
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveRule(Rule &$Rule) 
    {
        // 写入要更新的数据
        $Rule->content = Request::instance()->post('content');
		$Rule->create_time = Request::instance()->post('create_time');

        // 更新或保存
        return $Rule->validate()->save();
    }

    public function index2(){
        $rules = Rule::paginate(5);
		$this->assign('rules', $rules);

		return $this->fetch();
    }
}