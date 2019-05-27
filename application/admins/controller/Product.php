<?php
namespace app\admins\controller;
use think\Controller;
use Util\SysDb;
// 商品管理
class Product extends Base{
	// 商品列表
	public function index(){
		$data['wd'] = trim(input('get.wd'));
		$where = [];
		if($data['wd']){
			$where = 'title like "%'.$data['wd'].'%" or pro_no="'.$data['wd'].'"';
		}

		$data['lists'] = $this->db->table('product')->where($where)->order('id desc')->pages(10);
		$data['status_list'] = array(-1=>'已删除',0=>'正常',1=>'下架');
		// 商品分类
		$data['cates'] = $this->db->table('product_cates')->cates('id');
		// 当前页
		$data['page'] = max(1,(int)input('get.page'));
		
		return $this->fetch('',$data);
	}

	// 商品发布
	public function add(){
		$pro_id = (int)input('get.pro_id');
		$data['product'] = $this->db->table('product')->where(array('id'=>$pro_id))->item();
		$data['detail'] = $this->db->table('product_detail')->where(array('product_id'=>$pro_id))->item();
		$img_list = $this->db->table('product_img')->where(array('product_id'=>$pro_id))->lists();
		$data['img_list'] = array_column($img_list, 'url');

		$data['cates'] = $this->db->table('product_cates')->order('ord asc')->lists();

		return $this->fetch('',$data);		
	}

	// 上传图片
	public function upload_img(){
		$file = request()->file('file');
		if($file == null){
			exit(json_encode(array('code'=>1,'msg'=>'没有文件上传')));
		}
		$info = $file->move(APP_PATH.'../public/uploads');
		// 文件扩展名
		$ext = $info->getExtension();
		if(!in_array(strtolower($ext),array('jpg','jpeg','gif','png'))){
			exit(json_encode(array('code'=>1,'msg'=>'文件格式不支持')));
		}
		$img = '/uploads/'.$info->getSaveName();

		$flag = (int)input('get.flag');	// 是否是富文本编辑器上传
		if($flag){
			exit(json_encode(array('errno'=>0,'data'=>array($img))));
		}
		exit(json_encode(array('code'=>0,'msg'=>$img)));
	}

	// 生成商品编码
	public function auto_create_no(){
		$pro_no = rand(10000,50000).time().rand(50000,99999);
		exit(json_encode(array('code'=>0,'msg'=>$pro_no)));
	}

	// 保存商品
	public function save(){

		$pro_id = (int)input('post.pro_id');

		$data['cid'] = (int)input('post.cid');
		$data['title'] = trim(input('post.title'));
		$data['pro_no'] = trim(input('post.pro_no'));
		$imgs = ltrim(input('post.img'),';');
		$data['price'] = (int)input('post.price');
		$data['orignal_price'] = (int)input('post.orignal_price');
		$data['cost'] = (int)input('post.cost');
		$data['stock'] = (int)input('post.stock');
		$data['keywords'] = trim(input('post.keywords'));
		$data['desc'] = trim(input('post.desc'));
		$detail = input('post.detail');
		$data['status'] = (int)input('status');

		if($data['title']==''){
			exit(json_encode(array('code'=>1,'msg'=>'商品名称不能为空')));
		}
		if($data['pro_no']==''){
			exit(json_encode(array('code'=>1,'msg'=>'商品编码不能为空')));
		}
		if(strlen($data['pro_no'])>20){
			exit(json_encode(array('code'=>1,'msg'=>'商品编码不正确')));
		}
		if($data['price']<=0){
			exit(json_encode(array('code'=>1,'msg'=>'商品价格不能为零')));
		}
		if($data['keywords']==''){
			exit(json_encode(array('code'=>1,'msg'=>'商品关键字不能为空')));
		}
		if($data['desc']==''){
			exit(json_encode(array('code'=>1,'msg'=>'商品描述不能为空')));
		}
		if($imgs==''){
			exit(json_encode(array('code'=>1,'msg'=>'请传商品图片')));
		}

		if($pro_id == 0){
			// 添加
			$data['add_time'] = time();
			$pro_id = $this->db->table('product')->insert($data);
			// 商品详情
			$pro_detail['product_id'] = $pro_id;
			$pro_detail['detail'] = $detail;
			$this->db->table('product_detail')->insert($pro_detail);
		}else{
			$this->db->table('product')->where(array('id'=>$pro_id))->update($data);
			$this->db->table('product_detail')->where(array('product_id'=>$pro_id))->update(array('detail'=>$detail));
		}
		// 商品图片
		$img_list = explode(';', $imgs);
		$this->db->table('product_img')->where(array('product_id'=>$pro_id))->delete();
		$img_data = array();
		foreach ($img_list as $key => $value) {
			$img_data[] = array('product_id'=>$pro_id,'url'=>$value);
		}
		$this->db->table('product_img')->insertAll($img_data);
		// 商品主图
		$this->db->table('product')->where(array('id'=>$pro_id))->update(array('img'=>$img_list[0]));

		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}

	// 商品删除
	public function delete(){
		$pro_id = (int)input('post.id');
		$this->db->table('product')->where(array('id'=>$pro_id))->update(array('status'=>-1));
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}
}