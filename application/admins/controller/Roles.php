<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;

class Roles extends Base{
	public function index(){
		$data['lists'] = $this->db->table('admin_groups')->lists();
		return $this->fetch('',$data);
	}

	// 添加角色
	public function add(){
		$gid = (int)input('get.gid');
		$group = $this->db->table('admin_groups')->where(array('gid'=>$gid))->item();
		if($group){
			$group['rights'] = json_decode($group['rights']);
		}

		$menu_list = $this->db->table('admin_menus')->where(array('status'=>0))->cates('mid');
		$menu = $this->gettreeitems($menu_list);

		$results = [];
		foreach ($menu as $value) {
			$value['children'] = isset($value['children'])?$this->formatMenus($value['children']):false;
			$results[] = $value;
		}
		$data['menus'] = $results;
		$data['group'] = $group;
		return $this->fetch('',$data);
	}

	private function gettreeitems($items){
		$tree = [];
		foreach ($items as $item) {
			if(isset($items[$item['pid']])){
				$items[$item['pid']]['children'][] = &$items[$item['mid']];
			}else{
				$tree[] = &$items[$item['mid']];
			}
		}
		return $tree;
	}

	private function formatMenus($items,&$res = array()){
		foreach ($items as $item) {
			if(!isset($item['children'])){
				$res[] = $item;
			}else{
				$tem = $item['children'];
				unset($item['children']);
				$res[] = $item;
				$this->formatMenus($tem,$res);
			}
		}
		return $res;
	}

	// 角色保存
	public function save(){
		$gid = (int)input('post.gid');

		$data['title'] = trim(input('post.title'));
		$menus = input('post.menu/a');
		if(!$data['title']){
			exit(json_encode(array('code'=>1,'msg'=>'角色名称不能为空')));
		}
		$menus && $data['rights'] = json_encode(array_keys($menus));

		if($gid){
			$this->db->table('admin_groups')->where(array('gid'=>$gid))->update($data);
		}else{
			$this->db->table('admin_groups')->insert($data);
		}
		
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}

	// 删除角色
	public function delete(){
		$gid = (int)input('post.gid');
		$this->db->table('admin_groups')->where(array('gid'=>$gid))->delete();
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}

}