<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
	<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 10px;">
	<form class="layui-form">
		<input type="hidden" name="id" value="{$item.id}">
		<div class="layui-form-item">
			<label class="layui-form-label">用户名</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="username" value="{$item.username}" <?=$item['id']>0?'readonly':''?>>
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">角色</label>
			<div class="layui-input-inline">
				<select name="gid">
					<option value="1">系统管理员</option>
					<option value="2">开发人员</option>
					<option value="3">网站编辑</option>
				</select>
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">密码</label>
			<div class="layui-input-inline">
				<input type="password" class="layui-input" name="password">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">姓名</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="truename" value="{$item.truename}">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">状态</label>
			<div class="layui-input-inline">
				<input type="checkbox" name="status" lay-skin="primary" title="禁用" value="1" {$item.status?'checked':''}>
			</div>
		</div>
	</form>
	<div class="layui-form-item">
		<div class="layui-input-block">
			<button class="layui-btn" onclick="save()">保存</button>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	layui.use(['layer','form'],function(){
		var form = layui.form;
		layer = layui.layer;
		$ = layui.jquery;
	});

	function save(){
		var id = parseInt($('input[name="id"]').val());
		var username = $.trim($('input[name="username"]').val());
		var pwd = $.trim($('input[name="password"]').val());
		var truename = $.trim($('input[name="truename"]').val());
		var gid = $('select[name="gid"]').val();

		if(username==''){
			layer.alert('请输入用户名',{'icon':2});
			return;
		}
		if(isNaN(id) && pwd==''){
			layer.alert('请输入密码',{'icon':2});
			return;
		}
		if(truename==''){
			layer.alert('请输入真实姓名',{'icon':2});
			return;
		}

		$.post('/index.php/admins/admin/save',$('form').serialize(),function(res){
			if(res.code>0){
				layer.alert(res.msg,{'icon':2});
			}else{
				layer.msg(res.msg,{'icon':1});

				setTimeout(function(){parent.window.location.reload();},1000);
			}
		},'json');
	}
</script>