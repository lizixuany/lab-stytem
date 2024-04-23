<?php
namespace app\index\controller;
use app\common\model\Centre;
use think\Request;                  // 引用Request
use think\Controller;

class CentreController extends Controller
{
	public function index()
	{    
		// 获取查询信息
		$name = Request::instance()->get('content');

		// 实例化F
		$Centre = new Centre;

		// 定制查询信息
		if (!empty($name)) {
			$Centre->where('name', 'like', '%' . $name . '%');
		}

		$centres = Centre::paginate(5);
		$this->assign('centres', $centres);

		return $this->fetch();
	}

	public function upload(){
		// 获取表单上传文件 例如：1.png
		$file = request()->file('image');

		// 移动到框架应用根目录/public/image/ 目录下
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'image');
			
			if($info){
				// 成功上传后 获取上传信息
				// a902d02fae5cdd89f86aacc71730ac15.png
				$filename = $info->getFilename(); 

				// 实例化请求信息
				$id = Request::instance()->param('id/d');

				// 判断是否存在当前记录
				if (is_null($Centre = Centre::get($id))) {
					return $this->error('未找到ID为' . $id . '的记录');
				}
				$content = '/thinkphp5/public/image/' . "$filename";
				$Centre->content = $content;
		
				// 添加数据
				if (!$Centre->validate(true)->save()) {
					return $this->error('数据添加错误：' . $Centre->getError());
				}
		
				return $this->success('操作成功', url('Centre/index'));
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
	}

	public function index2(){
        $centres = Centre::paginate(5);
		$this->assign('centres', $centres);

		return $this->fetch();
    }
}