<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
	<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
</head>
<body style="padding: 10px;">
	<form class="layui-form">
		<input type="hidden" name="pid" value="{$parent_menu.mid}">
		<input type="hidden" name="mid" value="{$menu.mid}">
		<?php if($parent_menu){?>
		<div class="layui-form-item">
			<label class="layui-form-label"><span style="color: green;">上级菜单</span></label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" disabled="true" style="color: green;" value="{$parent_menu.title}">
			</div>
		</div>
		<?php }?>

		<div class="layui-form-item">
			<label class="layui-form-label">菜单名称</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="title" value="{$menu.title}">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">排序</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="ord" value="{$menu.ord}">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">控制器</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="controller" value="{$menu.controller}">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">方法</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="method" value="{$menu.method}">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">状态</label>
			<div class="layui-input-inline">
				<input type="checkbox" name="ishidden" lay-skin="primary" title="是否隐藏" value="1" {$menu.ishidden==1?'checked':''}>
				<input type="checkbox" name="status" lay-skin="primary" title="是否禁用" value="1" {$menu.status==1?'checked':''}>
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
		var pid = parseInt($('input[name="pid"]').val());
		var title = $.trim($('input[name="title"]').val());
		var controller = $.trim($('input[name="controller"]').val());
		var method = $.trim($('input[name="method"]').val());

		if(title==''){
			layer.alert('请输入菜单名称',{'icon':2});
			return;
		}
		
		if(pid>0 && controller==''){
			layer.alert('请输入控制器',{'icon':2});
			return;
		}
		if(pid>0 && method==''){
			layer.alert('请输入方法名称',{'icon':2});
			return;
		}

		$.post('/index.php/admins/menu/save',$('form').serialize(),function(res){
			if(res.code>0){
				layer.alert(res.msg,{'icon':2});
			}else{
				layer.msg(res.msg,{'icon':1});

				setTimeout(function(){parent.window.location.reload();},1000);
			}
		},'json');
	}
</script>