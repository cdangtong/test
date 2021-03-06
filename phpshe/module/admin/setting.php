<?php
/**
 * @copyright   2008-2014 简好技术 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
pe_lead('hook/cache.hook.php');
switch ($act) {
	//#####################@ 基本信息 @#####################//
	default:
		$menumark = 'setting_base';
		if (isset($_p_pesubmit)) {
			if ($_FILES['web_logo']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['web_logo']);
				$_p_info['web_logo'] = $upload->filehost;
				$sqlset = "when 'web_logo' then '{$upload->filehost}'";
			}
			$sql = "update `".dbpre."setting` set `setting_value` = case `setting_key` {$sqlset}
				when 'web_title' then '".pe_dbhold($_p_info['web_title'])."'
				when 'web_keywords' then '".pe_dbhold($_p_info['web_keywords'])."'
				when 'web_description' then '".pe_dbhold($_p_info['web_description'])."'
				when 'web_title' then '".pe_dbhold($_p_info['web_title'])."'
				when 'web_copyright' then '".pe_dbhold($_p_info['web_copyright'])."'
				when 'web_icp' then '".pe_dbhold($_p_info['web_icp'])."'
				when 'web_phone' then '".pe_dbhold($_p_info['web_phone'])."'
				when 'web_weibo' then '".pe_dbhold($_p_info['web_weibo'])."'
				when 'web_qq' then '".pe_dbhold($_p_info['web_qq'])."'
				when 'web_wlname' then '".pe_dbhold(serialize($_p_web_wlname), 'all')."'
				when 'email_smtp' then '".pe_dbhold($_p_info['email_smtp'])."'
				when 'email_port' then '".pe_dbhold($_p_info['email_port'])."'
				when 'email_name' then '".pe_dbhold($_p_info['email_name'])."'
				when 'email_pw' then '".pe_dbhold($_p_info['email_pw'])."'
				when 'email_nname' then '".pe_dbhold($_p_info['email_nname'])."'
				when 'web_tongji' then '".pe_dbhold($_p_info['web_tongji'], 'all')."' else `setting_value` end";
			if ($db->sql_update($sql)) {
				cache_write('setting');
				pe_success('网站设置成功!');
			}
			else {
				pe_error('网站设置失败...');
			}
		}
		$info = $db->index('setting_key')->pe_selectall('setting');
		$tpl_arr = pe_dirlist("{$pe['path_root']}template/*");

		$seo = pe_seo($menutitle='网站设置', '', '', 'admin');
		include(pe_tpl('setting_base.html'));
	break;
}
?>