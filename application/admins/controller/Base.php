<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;

class Base extends Controller{
	public function __construct(){
		parent::__construct();
		$this->_admin = session('admin');
		if(!$this->_admin){
			header('Location:/index.php/admins/account/login');
			exit;
		}
		$this->assign('admin',$this->_admin);
		$this->db = new SysDb;
		// 判断用户是否有权限
		$group = $this->db->table('admin_groups')->where(array('gid'=>$this->_admin['gid']))->item();
		if(!$group){
			$this->request_error('对不起，您没有权限');
		}
		$rights = json_decode($group['rights']);
		// 当前访问的菜单
		$controller = request()->controller();
		$method = request()->action();
		$res = $this->db->table('admin_menus')->where(array('controller'=>$controller,'method'=>$method))->item();
		if(!$res){
			$this->request_error('对不起，您访问的功能不存在');
		}
		if($res['status'] == 1){
			$this->request_error('对不起，该功能已禁止使用');
		}
		if(!in_array($res['mid'],$rights)){
			$this->request_error('对不起，您没有权限');
		}
	}

	private function request_error($msg){
		if(request()->isAjax()){
			exit(json_encode(array('code'=>1,'msg'=>$msg)));
		}
		exit($msg);
	}

}