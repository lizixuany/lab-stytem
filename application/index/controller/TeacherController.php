<?php
namespace app\index\controller;     // 该文件的位于application\index\controller文件夹

use think\Controller;               // 用于与V层进行数据传递
use think\Request;                  // 引用Request
use think\Db;
use app\common\model\Teacher;       // 教师模型

/**
 * 教师管理，继承think\Controller后，就可以利用V层对数据进行打包了。
 */
class TeacherController extends Controller
{
    public function index()
    {
        try {     
        // 获取查询信息
		$name = Request::instance()->get('name');

		// 实例化F
		$Teacher = new Teacher;

        $Teacher->where('')->order('role desc');
		// 定制查询信息
		if (!empty($name)) {
			$Teacher->where('name', 'like', '%' . $name . '%')->order('role desc');
		}

        $teachers = Teacher::paginate(5);
        
        $this->assign('teachers', $teachers);
		return $this->fetch();

        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 判断用户是否已登录
     * @return boolean 已登录true
     * @author  panjie <panjie@yunzhiclub.com>
     */
    static public function isLogin()
    {
        return true;
    }

    /**
     * 插入新数据
     * @return   html                   
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T12:31:24+0800
     */
    public function save()
    {
        try {
            // 实例化
        $Teacher = new Teacher;

        // 新增数据
        if (!$this->saveTeacher($Teacher)) {
            return $this->error('操作失败' . $Teacher->getError());
        }
    
        // 成功跳转至index触发器
        return $this->success('操作成功', url('index'));
            
        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

        return $this->error($message);
    }

    /**
     * 新增数据交互
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-07T12:41:23+0800
     */
    public function add()
    {
        try {
            // 实例化
        $Teacher = new Teacher;

        // 设置默认值
        $Teacher->id = 0;
        $Teacher->name = '';
        $Teacher->role = 0;
        $Teacher->content = '';
        $Teacher->study = '';
        $Teacher->success = '';
        $this->assign('Teacher', $Teacher);

        // 调用edit模板
        return $this->fetch('edit');
        } catch (\Exception $e) {
            return '系统错误' . $e->getMessage();
        }
    }

    public function delete()
    {
        try {
            // 实例化请求类
            $Request = Request::instance();
            
            // 获取get数据
            $id = Request::instance()->param('id/d');

            // 判断是否成功接收
            if (0 === $id) {
                throw new \Exception('未获取到ID信息', 1);
            }

            // 获取要删除的对象
            $Teacher = Teacher::get($id);

            // 要删除的对象存在
            if (is_null($Teacher)) {
                throw new \Exception('不存在id为' . $id . '的教师，删除失败', 1);
            }

            // 删除对象
            if (!$Teacher->delete()) {
                return $this->error('删除失败:' . $Teacher->getError());
            }

        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        } 

        // 进行跳转 
        return $this->success('删除成功', $Request->header('referer'));
    }

    public function edit()
    {
        try {
            // 获取传入ID
            $id = Request::instance()->param('id/d');

            // 判断是否成功接收
            if (is_null($id) || 0 === $id) {
                throw new \Exception('未获取到ID信息', 1);
            }
            
            // 在Teacher表模型中获取当前记录
            if (null === $Teacher = Teacher::get($id))
            {
                // 由于在$this->error抛出了异常，所以也可以省略return(不推荐)
                $this->error('系统未找到ID为' . $id . '的记录');
            } 
            
            // 将数据传给V层
            $this->assign('Teacher', $Teacher);

            // 获取封装好的V层内容
            $htmls = $this->fetch();

            // 将封装好的V层内容返回给用户
            return $htmls;

        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
    }

    public function update()
    {
        try {
            // 接收数据，取要更新的关键字信息
            $id = Request::instance()->post('id/d');

            // 获取当前对象
            $Teacher = Teacher::get($id);

            if (!is_null($Teacher)) {
                if (!$this->saveTeacher($Teacher, true)) {
                    return $this->error('操作失败' . $Teacher->getError());
                }
            } else {
                return $this->error('当前操作的记录不存在');
            }
        
            // 成功跳转至index触发器
            return $this->success('操作成功', url('index'));

        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
        
        // 成功跳转至index触发器
        return $this->success('操作成功', url('index'));
    }

    /**
     * 对数据进行保存或更新
     * @param    Teacher                  &$Teacher 教师
     * @param    bool$isTeacher(Teacher &$Teacher, $isUpdate = false)
     * @return   bool                             
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-24T15:24:29+0800
     */
    private function saveTeacher(Teacher &$Teacher, $isUpdate = false) 
    {
        // 写入要更新的数据
        $Teacher->name = Request::instance()->post('name');
        $Teacher->role = Request::instance()->post('role');
        $Teacher->content = Request::instance()->post('content');
        $Teacher->study = Request::instance()->post('study');
        $Teacher->success = Request::instance()->post('success');

        // 更新或保存
        return $Teacher->validate(true)->save();
    }

    public function index2(){
        $pageSize = 5; //每页显示5条数据

        //获取数据
        $teacher = new Teacher();
        $teacherList = $teacher->getList();

        //调用分页
		$teacherList = $teacher->paginate($pageSize);

        // 存储状态为2的角色
        $topTeachers = array();
        // 存储状态为1的角色
        $normalTeachers = array();
        // 存储状态为0的角色
        $bottomTeachers = array();
            
        // 将状态为1的数据置顶
        foreach($teacherList as $teacher) {
            if($teacher['role'] == 2) {
                $topTeachers[] = $teacher;
            } else if($teacher['role'] == 1){
                $normalTeachers[] = $teacher;
            } else {
                $bottomTeachers[] = $teacher;
            }
        }
        
        //将数据传递给首页模板
        $this->assign('topTeachers',$topTeachers);
        $this->assign('normalTeachers',$normalTeachers);
        $this->assign('bottomTeachers',$bottomTeachers);

        //传递给首页模板
        $this->assign('teacherList',$teacherList);

        //渲染首页模板
        return $this->fetch();
 
    }
}

