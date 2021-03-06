<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $seo['title'] ?></title>
<meta name="keywords" content="<?php echo $seo['keywords'] ?>" />
<meta name="description" content="<?php echo $seo['description'] ?>" />
<link rel="shortcut icon" type="image/ico" href="<?php echo $pe['host_root'] ?>favicon.ico">
<link type="text/css" rel="stylesheet" href="<?php echo $pe['host_tpl'] ?>css/style.css" />
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/global.js"></script>
</head>
<body>
<div class="pagetop">
	<div class="quick_menu">
		<p>
		<?php if(pe_login('user')):?>
		<span class="fl">您好，<span class="cred"><?php echo $_s_user_name ?></span>， <?php echo $cache_setting['web_title']['setting_value'] ?>！</span>
		<span class="fr">
		<a href="<?php echo $pe['host_root'] ?>index.php?mod=user&act=order" title="会员中心">会员中心</a>
		<a href="<?php echo $pe['host_root'] ?>index.php?mod=order&act=add" title="购物车" class="gwc">购物车 <span class="cred"><?php echo $cart_num ?></span> 件</a>
		<?php if($cache_setting['web_weibo']['setting_value']):?>
		<a href="<?php echo $cache_setting['web_weibo']['setting_value'] ?>" title="官方微博" target="_blank">官方微博</a>
		<?php else:?>
		<a href="<?php echo pe_url('order-list') ?>" title="订单查询">订单查询</a>
		<a href="<?php echo pe_url('user-logout') ?>" title="退出" style="border:0">退出</a>
		</span>
		<?php endif;?>
		<?php else:?>
		<span class="fl">您好，欢迎来到<?php echo $cache_setting['web_title']['setting_value'] ?>！</span>
		<span class="fr">
		<a href="<?php echo pe_url('user-login',pe_fromto()) ?>" title="登录">登录</a>
		<a href="<?php echo pe_url('user-register',pe_fromto()) ?>" title="注册">注册</a>
		<?php if($cache_setting['web_weibo']['setting_value']):?>
		<a href="<?php echo $cache_setting['web_weibo']['setting_value'] ?>" title="官方微博" target="_blank">官方微博</a>
		<?php endif;?>
		<a href="<?php echo $pe['host_root'] ?>index.php?mod=order&act=add" title="购物车" class="gwc">购物车 <span class="cred"><?php echo $cart_num ?></span> 件</a>
		<a href="<?php echo pe_url('order-list') ?>" title="订单查询" style="border:0">订单查询</a>
		</span>
		<?php endif;?>
		</p>
	</div>
	<div class="width980">
		<div class="header">
			<div class="fl logo"><a href="<?php echo $pe['host_root'] ?>" title="<?php echo $cache_setting['web_name']['setting_value'] ?>"><img src="<?php echo pe_thumb($cache_setting['web_logo']['setting_value']) ?>" alt="<?php echo $cache_setting['web_name']['setting_value'] ?>" /></a></div>
			<p class="top_tel fr">咨询热线：<?php echo $cache_setting['web_phone']['setting_value'] ?></p>
			<div class="sear fr">				
				<form method="get" action="<?php echo pe_url('product-list') ?>">
				<div class="inputbg fl"><input type="text" name="keyword" value="<?php echo htmlspecialchars($_g_keyword) ?>" class="fl searinput c666" /></div>
				<input type="submit" class="fl sear_btn" onclick="this.form.submit();return false;" value=" " />
				</form>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="nav">
		<div class="width980">
		<ul>
			<li class="sel"><a href="<?php echo $pe['host_root'] ?>" title="首页">首页</a></li>
			<?php foreach((array)$cache_menu as $v):?>
			<?php if($v['menu_type'] == 'sys'):?>
			<li><a href="<?php echo pe_url($v['menu_url']) ?>" title="<?php echo $v['menu_name'] ?>"><?php echo $v['menu_name'] ?></a></li>
			<?php else:?>
			<li><a href="<?php echo $v['menu_url'] ?>" title="<?php echo $v['menu_name'] ?>" target="_blank"><?php echo $v['menu_name'] ?></a></li>
			<?php endif;?>
			<?php endforeach;?>
		</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php if($mod=='index' && is_array($cache_ad['index_header'])):?>
<?php foreach($cache_ad['index_header'] as $v):?>
<div class="ad980">
<?php if($v['ad_url']):?>
<a href="<?php echo $v['ad_url'] ?>" target="_blank"><img src="<?php echo pe_thumb($v['ad_logo']) ?>" /></a>
<?php else:?>
<img src="<?php echo pe_thumb($v['ad_logo']) ?>" />
<?php endif;?>
</div>
<?php endforeach;?>
<?php endif;?>
<?php if(is_array($cache_ad['header'])):?>
<?php foreach($cache_ad['header'] as $v):?>
<div class="ad980">
<?php if($v['ad_url']):?>
<a href="<?php echo $v['ad_url'] ?>" target="_blank"><img src="<?php echo pe_thumb($v['ad_logo']) ?>" /></a>
<?php else:?>
<img src="<?php echo pe_thumb($v['ad_logo']) ?>" />
<?php endif;?>
</div>
<?php endforeach;?>
<?php endif;?>