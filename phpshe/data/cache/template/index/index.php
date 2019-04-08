<?php include(pe_tpl('header.html'));?>
<div class="content">
		<div class="jdt fl">
			<div id="jdtslide" style="visibility:hidden;">
			<?php if(is_array($cache_ad['index_jdt'])):?>
			<?php foreach($cache_ad['index_jdt'] as $v):?>
			<a href="<?php echo $v['ad_url'] ?>"><img src="<?php echo pe_thumb($v['ad_logo']) ?>" alt="" width="730" height="300" /></a>
			<?php endforeach;?>
			<?php endif;?>
			</div>
		</div>
		<div class="fr action_list">
			<div class="action_tt"><h3><?php echo $cache_class[1]['class_name'] ?></h3></div>
			<ul>
				<?php foreach($notice_list as $k=>$v):?>
				<li <?php if($k>=7):?>style="border-bottom:0"<?php endif;?>><a href="<?php echo pe_url('article-'.$v['article_id']) ?>" title="<?php echo $v['article_name'] ?>" target="_blank"><?php echo $v['article_name'] ?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div class="index_main">
		<div class="pro_tuijian">
			<div class="index_fenlei_tt1">
				<h3>★ 本店推荐 ★</h3>
			</div>
			<div class="tuijian_list">
				<?php foreach($product_tuijian as $k=>$v):?>
				<div class="prolist_1" <?php if($k==4):?>style="margin-right:0"<?php endif?>>
					<p class="prolist_img"><a href="<?php echo pe_url('product-'.$v['product_id']) ?>" title="<?php echo $v['product_name'] ?>" target="_blank"><img src="<?php echo $pe['host_root'] ?>include/image/load.gif" data-original="<?php echo pe_thumb($v['product_logo'], 180, 180) ?>" title="<?php echo $v['product_name'] ?>" /></a></p>
					<div style="padding:3px 5px">
						<p class="prolist_name"><a href="<?php echo pe_url('product-'.$v['product_id']) ?>" title="<?php echo $v['product_name'] ?>" target="_blank"><?php echo $v['product_name'] ?></a></p>
						<p><span class="money1 fl"><span class="num mar3">¥</span><?php echo $v['product_money'] ?></span> <s class="num c888 fr">¥ <?php echo $v['product_smoney'] ?></s></p>
					</div>
				</div>
				<?php endforeach;?>
				<div class="clear"></div>
			</div>
		</div>
		<!--分类1 Start-->
		<?php foreach((array)$category_indexlist as $k=>$v):?>
		<div class="pro_tuijian mat10">
			<div class="index_fenlei_tt1">
				<h3 class="fl"><?php echo $k+1 ?>F <?php echo $v['category_name'] ?></h3>
				<span class="fr"><a href="<?php echo pe_url('product-list-'.$v['category_id']) ?>" title="<?php echo $v['category_name'] ?>" target="_blank">更多>></a></span>
			</div>
			<div class="tuijian_list">
				<?php foreach($v['product_newlist'] as $kk=>$vv):?>
				<div class="prolist_1" <?php if(($kk+1)%5==0):?>style="margin-right:0"<?php endif;?>>
					<p class="prolist_img"><a href="<?php echo pe_url('product-'.$vv['product_id']) ?>" title="<?php echo $vv['product_name'] ?>" target="_blank"><img src="<?php echo $pe['host_root'] ?>include/image/load.gif" data-original="<?php echo pe_thumb($vv['product_logo'], 180, 180) ?>" title="<?php echo $vv['product_name'] ?>" /></a></p>
					<div style="padding:3px">
						<p class="prolist_name"><a href="<?php echo pe_url('product-'.$vv['product_id']) ?>" title="<?php echo $vv['product_name'] ?>" target="_blank"><?php echo $vv['product_name'] ?></a></p>
						<p><span class="money1 fl"><span class="num mar3">¥</span><?php echo $vv['product_money'] ?></span> <s class="num c888 fr">¥ <?php echo $vv['product_smoney'] ?></s></p>
					</div>
				</div>
				<?php endforeach;?>
				<div class="clear"></div>
			</div>
		</div>
		<?php endforeach;?>
		<!--分类1 End-->
</div>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/jquery.slide.js"></script>
<script type="text/javascript">
$(function(){
	$("img").lazyload({
		effect:"fadeIn",
		container:$("body")
	});
	$("#jdtslide").KinSlideshow({
		moveStyle:"left",
		intervalTime:5,
		mouseEvent:"mouseover",
		titleBar:{"titleBar_bgColor":""},
		titleFont:{TitleFont_size:14,TitleFont_color:"#ffffff"}
	});
	$(".fenlei_li").hover(
		function(){	
			$(".fenlei_li").find("h3 a").removeClass("sel");	
			$(this).find("h3 a").addClass("sel");
			$(".fenlei_li").find("div").hide();	
			$(this).find("div").show();
		},
		function(){
			$(".fenlei_li").find("h3 a").removeClass("sel");
			$(".fenlei_li").find("div").hide();	
		}
	)
})
</script>
<?php include(pe_tpl('footer.html'));?>