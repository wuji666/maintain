<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;

class Account extends Controller{

    public function login(){
    	return $this->fetch();
	}

	public function dologin(){
		$username = trim(input('post.username'));
		$password = input('post.password');
		$verifycode = input('post.verifycode');
		if($username == ''){
			exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
		}
		if($password == ''){
			exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
		}
		if($verifycode==''){
			exit(json_encode(array('code'=>1,'msg'=>'验证码不能为空')));
		}
		if(!captcha_check($verifycode)){
			exit(json_encode(array('code'=>1,'msg'=>'验证码不正确')));
		}
		// 验证用户
		$this->db = new SysDb;
		$admin = $this->db->table('admins')->where(array('username'=>$username))->item();
		if(!$admin){
			exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
		}
		if(md5($admin['username'].$password) != $admin['password']){
			exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
		}
		if($admin['status']==1){
			exit(json_encode(array('code'=>1,'msg'=>'用户已被禁用')));
		}
		// 设置用户session
		session('admin',$admin);
		exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
	}

	// 退出登录
	public function logout(){
		session('admin',null);
		exit(json_encode(array('code'=>0,'msg'=>'退出成功')));
	}
}