<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;

class Menu extends Base{
	public function index(){
		$pid = (int)input('get.pid');
		$where['pid'] = $pid;
		// 加载菜单列表
		$data['lists'] = $this->db->table('admin_menus')->where($where)->order('ord asc')->lists();
		$data['pid'] = $pid;

		// 子菜单
		if($pid>0){
			$parent = $this->db->table('admin_menus')->where(array('mid'=>$pid))->item();
			$data['backid'] = $parent['pid'];
		}
		return $this->fetch('',$data);
	}

	// 添加、编辑菜单
	public function add(){
		$pid = (int)input('get.pid');
		$mid = (int)input('get.mid');
		$data['parent_menu'] = $this->db->table('admin_menus')->where(array('mid'=>$pid))->item();
		$data['menu'] = $this->db->table('admin_menus')->where(array('mid'=>$mid))->item();
		return $this->fetch('',$data);
	}

	// 保存菜单
	public function save(){
		$mid = (int)input('post.mid');
		$data['pid'] = (int)input('post.pid');
		$data['title'] = trim(input('post.title'));
		$data['controller'] = trim(input('post.controller'));
		$data['method'] = trim(input('post.method'));
		$data['ord'] = (int)input('post.ord');
		$data['ishidden'] = (int)input('post.ishidden');
		$data['status'] = (int)input('post.status');
 		
 		if($data['title'] == ''){
 			exit(json_encode(array('code'=>1,'msg'=>'菜单名称不能为空')));
 		}

 		if($data['pid']>0 && $data['controller'] == ''){
 			exit(json_encode(array('code'=>1,'msg'=>'控制器名称不能为空')));
 		}
 		if($data['pid']>0 && $data['method'] == ''){
 			exit(json_encode(array('code'=>1,'msg'=>'方法名称不能为空')));
 		}

 		if($mid){
 			$res = $this->db->table('admin_menus')->where(array('mid'=>$mid))->update($data);
 		}else{
 			$res = $this->db->table('admin_menus')->insert($data);
 		}

 		if(!$res){
 			exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
 		}
 		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}


	// 删除菜单
	public function delete(){
		$mid = (int)input('post.mid');
		$res = $this->db->table('admin_menus')->where(array('mid'=>$mid))->delete();
		if(!$res){
			exit(json_encode(array('code'=>1,'msg'=>'删除失败')));
		}
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}

}