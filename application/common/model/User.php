<?php
namespace app\common\model;
use think\Model;    //  导入think\Model类

/**
 * User 用户表
 */
class User extends Model
{
	/**
     * 用户登录
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool   成功返回true，失败返回false。
     */
    static public function login($username, $password)
    {
        // 验证用户是否存在
        $map = array('username' => $username);
        $User = self::get($map);
        
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->checkPassword($password)) {
                // 登录
                session('userId', $User->getData('id'));
                return true;
            }
        }
        return false;
    }

    /**
     * 判断用户是否已登录
     * @return boolean 已登录true
     * @author  panjie <panjie@yunzhiclub.com>
     */
    static public function isLogin()
    {
        $userId = session('userId');

        // isset()和is_null()是一对反义词
        if (isset($userId)) {
            return true;
        } else {
            return false;
        }
    }

    /**
	 * 验证密码是否正确
	 * @param  string $password 密码
	 * @return bool           
	 */
	public function checkPassword($password)
	{
		if ($this->getData('password') === $this::encryptPassword($password))
		{
			return true;
		} else {
			return false;
		}
	}

	/**
     * 密码加密算法
     * @param    string                   $password 加密前密码
     * @return   string                             加密后密码
     * @author panjie@yunzhiclub.com http://www.mengyunzhi.com
     * @DateTime 2016-10-21T09:26:18+0800
     */
    static public function encryptPassword($password)
    {   
        if (!is_string($password)) {
            throw new \RuntimeException("传入变量类型非字符串，错误码2", 2);
        }

        // 实际的过程中，我还还可以借助其它字符串算法，来实现不同的加密。
        return sha1(md5($password) . 'mengyunzhi');
    }

    /**
     * 注销
     * @return bool  成功true，失败false。
     * @author panjie
     */
    static public function logOut()
    {
        // 销毁session中数据
        session('userId', null);
        return true;
    }
}