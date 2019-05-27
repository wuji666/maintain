<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css">
	<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
	<style type="text/css">
		.header span{background: #009688;margin-left: 30px;padding: 10px;color: #ffffff;}
		.header button{float: right;margin-top: -5px;}
		.header div{border-bottom: solid 2px #009688;margin-top: 8px;}
	</style>
</head>
<body style="padding: 10px;">
	<input type="hidden" id="pid" value="{$pid}">
	<div class="header">
		<span>菜单列表</span>
		<button class="layui-btn layui-btn-sm" onclick="add()">添加</button>
		<div></div>
	</div>
	<?php if($pid>0){?>
	<button class="layui-btn layui-btn-primary layui-btn-sm" style="float: right;margin-top: 5px;margin-bottom: 5px;" onclick="backs({$backid})">返回上级菜单</button>
	<?php }?>
	<table class="layui-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>排序</th>
				<th>菜单名称</th>
				<th>控制器</th>
				<th>方法</th>
				<th>是否隐藏</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			{volist name='$lists' id="vo"}
			<tr>
				<td>{$vo.mid}</td>
				<td>{$vo.ord}</td>
				<td>{$vo.title}</td>
				<td>{$vo.controller}</td>
				<td>{$vo.method}</td>
				<td>{$vo.ishidden==1?'隐藏':'显示'}</td>
				<td>{$vo.status==1?'禁用':'正常'}</td>
				<td>
					<button class="layui-btn layui-btn-xs" onclick="childs({$vo.mid})">子菜单</button>
					<button class="layui-btn layui-btn-warm layui-btn-xs" onclick="add({$vo.mid})">编辑</button>
					<button class="layui-btn layui-btn-danger layui-btn-xs" onclick="del({$vo.mid})">删除</button>
				</td>
			</tr>
			{/volist}
		</tbody>
	</table>
</body>
</html>
<script type="text/javascript">
	layui.use(['layer'],function(){
		layer = layui.layer;
		$ = layui.jquery;
	});

	// 添加
	function add(mid){
		var pid = $('#pid').val();
		layer.open({
			type:2,
			title:mid>0?'编辑菜单':'添加菜单',
			shade:0.3,
			area:['480px','420px'],
			content:'/index.php/admins/menu/add?mid='+mid+'&pid='+pid
		});
	}

	// 删除
	function del(mid){
		layer.confirm('确定要删除吗？',{
			icon:3,
			btn:['确定','取消']
		},function(){
			$.post('/index.php/admins/menu/delete',{'mid':mid},function(res){
				if(res.code>0){
					layer.alert(res.msg,{'icon':2});
				}else{
					layer.msg(res.msg,{'icon':1});
					setTimeout(function(){window.location.reload();},1000);
				}
			},'json');
		});
	}

	// 子菜单
	function childs(mid){
		window.location.href = '?pid='+mid;
	}

	// 返回上级菜单
	function backs(pid){
		window.location.href = '?pid='+pid;
	}
</script>