<?php
/**
 * @copyright   2008-2014 简好技术 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */

$page_id = intval($act);
$info = $db->pe_select('page', array('page_id'=>$page_id));

$nowpath = " > 帮助中心 > <a href='".pe_url("page-{$page_id}")."'>{$info['page_name']}</a>";
$seo = pe_seo($info['page_name']);
include(pe_tpl('page.html'));
?>