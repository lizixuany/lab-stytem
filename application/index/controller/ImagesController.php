<?php
namespace app\index\controller;
use app\common\model\Images;
use think\Request;                  // 引用Request
use think\Controller;

class ImagesController extends Controller
{
    public function index(){
        // 获取查询信息
		$title = Request::instance()->get('title');

		// 实例化F
		$Images = new Images;

		// 定制查询信息
		if (!empty($title)) {
			$Images->where('title', 'like', '%' . $title . '%');
		}

		$imageses = Images::paginate(5);

		$this->assign('imageses', $imageses);

        return $this->fetch();
    }

	public function add() 
	{
		// 实例化
		$Images = new Images;

		// 设置默认值
		$Images->id = 0;
		$Images->route = '';
		$Images->title = '';
		$Images->content = '';
        $Images->state = '0';

		$this->assign('Images', $Images);

		return $this->fetch('edit');
	}

	public function save() 
	{
		// 实例化请求信息
       $Images = new Images;
       
        // 新增数据
        if (!$this->saveImages($Images)) {
            return $this->error('操作失败' . $Images->getError());
        }

        return $this->success('操作成功', url('index'));
	}

	public function edit()
	{
		$id = Request::instance()->param('id/d');

		// 判断是否存在当前记录
		if (is_null($Images = Images::get($id))) {
			return $this->error('未找到ID为' . $id . '的记录');
		}

		$this->assign('Images', $Images);
		return $this->fetch();
	}

	public function update() 
	{
		$id = Request::instance()->post('id/d');

        // 获取传入的信息
        $Images = Images::get($id);
        if (is_null($Images)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        // 新增数据
        if (!$this->saveImages($Images)) {
			return $this->success('操作成功', url('index'));
        }

		return $this->error('操作失败' . $Images->getError());
		}

	public function delete() {
		// 获取pathinfo传入的ID值.
		$id = Request::instance()->param('id/d');  // “/d”表示将数值转化为“整型”

		if (is_null($id) || 0 === $id) {
			return $this->error('未获取到ID信息');
		}

		// 获取要删除的对象
		$Images = Images::get($id);

		// 要删除的对象不存在
		if (is_null($Images)) {
			return $this->error('不存在id为' . $id . '的教师，删除失败');
		}

		// 删除对象
		if (!$Images->delete()) {
			return $this->error('删除失败:' . $Images->getError());
		}

		// 进行跳转
		return $this->success('删除成功', url('index'));
	}

	/**
     * 对数据进行保存或更新
     */
    private function saveImages(Images &$Images) 
    {
        // 写入要更新的数据
        $Images->route = Request::instance()->post('route');
		$Images->create_time = Request::instance()->post('create_time');
		$Images->title = Request::instance()->post('title');
		$Images->content = Request::instance()->post('content');
		$Images->state = Request::instance()->post('state');

        // 更新或保存
        return $Images->validate()->save();
    }

	public function upload(){
		// 获取表单上传文件 例如：1.png
		$file = request()->file('image');

		// 移动到框架应用根目录/public/image/ 目录下
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'image','');
			
			if($info){
				// 成功上传后 获取上传信息
				// a902d02fae5cdd89f86aacc71730ac15.png
				$filename = $info->getFilename(); 

				// 实例化请求信息
				$Request = Request::instance();
				$id = Request::instance()->param('id/d');

				if (0 !== $id) {
					$Images = Images::get($id);
				} else {
					$Images = new Images; 

					$Images->id = 0;
					$Images->title = '';
					$Images->content = '';
					$Images->state = 0;

				}

				$Images->route = '/thinkphp5/public/image/' . "$filename";
					
				// 添加数据
				if (!$Images->validate(true)->save()) {
					return $this->error('数据添加错误：' . $Images->getError());
				}
		
				$this->assign('Images', $Images);
				return $this->fetch('edit');
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
	}

}