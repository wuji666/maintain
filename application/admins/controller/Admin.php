<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;

class Admin extends Base{
	public function index(){
		// 加载管理员列表
		$data['lists'] = $this->db->table('admins')->order('id desc')->lists();
		return $this->fetch('',$data);
	}

	// 添加管理员
	public function add(){
		$id = (int)input('get.id');
		$data['item'] = $this->db->table('admins')->where(array('id'=>$id))->item();

		return $this->fetch('',$data);
	}


	// 保存管理员
	public function save(){
		$id = (int)input('post.id');
		$data['username'] = trim(input('post.username'));
		$data['gid'] = (int)input('post.gid');
		$data['truename'] = trim(input('post.truename'));
		$data['status'] = (int)input('post.status');
		$password = input('post.password');

		if(!$data['username']){
			exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
		}
		if(!$data['gid']){
			exit(json_encode(array('code'=>1,'msg'=>'角色不能为空')));
		}
		if(!$data['truename']){
			exit(json_encode(array('code'=>1,'msg'=>'姓名不能为空')));
		}

		if($id==0 && !$password){
			exit(json_encode(array('code'=>1,'msg'=>'请输入密码')));
		}
		if($password){
			$data['password'] = md5($data['username'].$password);
		}
		
		$res = true;
		if($id == 0){
			$item = $this->db->table('admins')->where(array('username'=>$data['username']))->item();
			if($item){
				exit(json_encode(array('code'=>1,'msg'=>'该用户已经存在')));
			}
			$data['add_time'] = time();
			$res = $this->db->table('admins')->insert($data);
		}else{
			$res = $this->db->table('admins')->where(array('id'=>$id))->update($data);
		}
		if($res){
			exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
		}else{
			exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
		}
		
	}


	// 删除管理员
	public function delete(){
		$id = (int)input('post.id');
		$res = $this->db->table('admins')->where(array('id'=>$id))->delete();
		if(!$res){
			exit(json_encode(array('code'=>1,'msg'=>'删除失败')));
		}
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}
}
