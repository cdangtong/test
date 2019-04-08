<?php include(pe_tpl('header.html'));?>
<div class="right">
	<div class="now">
		<span class="fl c888">管理中心 > <?php echo $menutitle ?></span>
		<span class="fr fabu"><a href="admin.php?mod=ad&act=add">增加链接</a></span>
		<div class="clear"></div>
	</div>
	<div class="right_main">
		<form method="post" id="form">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
		<tr>
			<td class="bgtt" width="60">ID号</td>
			<td class="bgtt" width="50">排序</td>
			<td class="bgtt">广告图片</td>
			<td class="bgtt" width="300">广告位置</td>
			<td class="bgtt" width="90">操作</td>
		</tr>
		<?php foreach($info_list as $v):?>
		<tr height="60">
			<td><?php echo $v['ad_id'] ?></td>
			<td><input type="text" name="ad_order[<?php echo $v['ad_id'] ?>]" value="<?php echo $v['ad_order'] ?>" class="inputtext input40" /></td>
			<td><a href="<?php echo $v['ad_url'] ?>" target="_blank"><img src="<?php echo pe_thumb($v['ad_logo']) ?>" height="80" width="300" /></a></td>
			<td><?php echo $ad_position[$v['ad_position']] ?></td>
			<td>
				<a href="admin.php?mod=ad&act=edit&id=<?php echo $v['ad_id'] ?>&token=<?php echo pe_token_set() ?>" class="admin_edit mar5">修改</a>
				<a href="admin.php?mod=ad&act=del&id=<?php echo $v['ad_id'] ?>&token=<?php echo pe_token_set() ?>" class="admin_del" onclick="return pe_cfone(this, '删除')">删除</a>
			</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td class="bgtt" colspan="5">
				<span class="fl"><button href="admin.php?mod=ad&act=order" onclick="pe_doall(this,'form')">批量排序</button></span>
				<span class="fenye"><?php echo $db->page->html ?></span>
			</td>
		</tr>
		</table>
		</form>
	</div>
</div>
<?php include(pe_tpl('footer.html'));?>