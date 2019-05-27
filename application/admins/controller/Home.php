<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;

class Home extends Base{

    public function index(){
    	$role = $this->db->table('admin_groups')->where(array('gid'=>$this->_admin['gid']))->item();
    	if($role){
    		$role['rights'] = $role['rights']?json_decode($role['rights'],true):[];
    	}
    	if($role['rights']){
    		$where = 'mid in('.implode(',', $role['rights']).') and ishidden=0 and status=0';
    		$menus = $this->db->table('admin_menus')->where($where)->cates('mid');
    		$menus && $menus = $this->gettreeitems($menus);
    	}

    	$data['menus'] = $menus;
    	$data['role'] = $role;
    	return $this->fetch('',$data);
	}

	public function welcome(){
		return $this->fetch();
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
}