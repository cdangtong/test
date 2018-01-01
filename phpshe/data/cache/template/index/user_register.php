<?php include(pe_tpl('header.html'));?>
<!--content Start-->
<div class="width980">
	<div class="loginbox registbox">
		<div class="logintt">用户注册</div>
		<form method="post" id="form">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="regist_table">
		<tr>
			<td width="15%" align="right">用户名:</td>
			<td width="33%"><input type="text" name="user_name" class="input1" /></td>
			<td width="52%"><span class="czong" id="user_name_show">由5-15位字符组成（可以是字母、汉字、数字）</span></td>
		</tr>
		<tr>
			<td align="right">密码:</td>
			<td><input type="password" name="user_pw" class="input1" /></td>
			<td><span class="czong" id="user_pw_show">密码由6-16个字符组成!</span></td>
		</tr>
		<tr>
			<td align="right">确认密码:</td>
			<td><input type="password" name="user_pw1" class="input1" /></td>
			<td><span class="czong" id="user_pw1_show"></span></td>
		</tr>
		<tr>
			<td align="right">邮箱:</td>
			<td><input type="text" name="user_email" class="input1" /></td>
			<td><span class="czong" id="user_email_show">请填写您的常用邮箱，以方便与您联系</span></td>
		</tr>
		<tr>
			<td align="right"></td>
			<td><input type="hidden" name="pesubmit" />
				<input type="button" class="btn_05" value="立即注册" style="margin:0" /></td>
			<td></td>
		</tr>
		</table>
		
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/formcheck.js"></script>
<script type="text/javascript">
$(function(){
var reg_checkname = function () {
	return	{'url':"<?php echo $pe['host_root'] ?>index.php",
			'data':{'mod':'user','act':'register','type':'checkname','user_name':$(":input[name='user_name']").val()}}
}
var reg_checkemail = function () {
	return	{'url':"<?php echo $pe['host_root'] ?>index.php",
			'data':{'mod':'user','act':'register','type':'checkemail','user_email':$(":input[name='user_email']").val()}}
}
var form_info = [
	{"name":"user_name", "mod":"str", "act":"blur", "arg":"5|15", "show_id":"user_name_show","show_error":"用户名为5-15位字符", "must":true},
	{"name":"user_name", "mod":"ajax", "act":"blur", "arg":reg_checkname, "show_id":"user_name_show","show_error":"该用户名已被注册", "must":true},
	{"name":"user_pw", "mod":"str", "act":"blur", "arg":"6|16", "show_id":"user_pw_show","show_error":"密码为6-20位字符", "must":true},
	{"name":"user_pw1", "mod":"str", "act":"blur", "arg":"6|16", "show_id":"user_pw1_show","show_error":"确认密码为6-20位字符", "must":true},
	{"name":"user_pw1", "mod":"equal", "act":"blur", "arg":$(":input[name='user_pw']"), "show_id":"user_pw1_show","show_error":"两次密码不一致", "must":true},
	{"name":"user_email", "mod":"match", "act":"blur", "arg":"email", "show_id":"user_email_show","show_error":"邮箱格式错误", "must":true},
	{"name":"user_email", "mod":"ajax", "act":"blur", "arg":reg_checkemail, "show_id":"user_email_show","show_error":"该邮箱已被注册", "must":true}
]
$(":button").pe_submit(form_info, 'form');
})
</script>
<!--content End--> 
<?php include(pe_tpl('footer.html'));?>