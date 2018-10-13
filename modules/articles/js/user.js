/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */
function nv_key_search_click(key,ck)
{
	window.location.href = nv_siteroot+"index.php?"+nv_lang_variable+"="+nv_sitelang+"&"+nv_name_variable+"=search&q="+rawurlencode(key)+"&search_checkss="+ck;
	return false;
}

function nv_del_articles (id,nv_base_admin_url,lang_confirm)
{
	if (confirm(lang_confirm))
	{
		var href = nv_base_admin_url + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=action&ac=del&id=' + id;
		$.ajax({	
			type: 'POST',
			url: href,
			data:'',
			success: function(data){				
				window.location = nv_siteroot + "index.php?" + nv_lang_variable + '=' + nv_sitelang  + '&' + nv_name_variable + '=' + nv_module_name;
			}
		});
	}
}

function clearinputtxt(id,txt_default){
	$("#"+id).focusin(function(){
			var txt = $(this).val();
			if (txt_default == txt ){
			$(this).val('');
		}
	});
	$("#"+id).focusout(function(){
		var txt = $(this).val();
		if ( txt == '') {
			$(this).val(txt_default);
		}
	});
}

function sendcommment(id, ck ) {
	var commentname = $('#idname').val();
	var commentemail = $('#idemail').val();
	var commentseccode = $('#seccode').val();
	var content = strip_tags($('#idcontent').val());
	nv_ajax('post', nv_siteroot + 'index.php', nv_lang_variable + '=' + nv_sitelang + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=comment&id=' + id + '&ck=' + ck + '&name=' + commentname + '&email=' + commentemail + '&code=' + commentseccode + '&content=' + encodeURIComponent(content), '', 'nv_commment_result');
	return;
}
function nv_commment_result(res) {
	nv_change_captcha('vimg', 'seccode');
	var r_split = res.split("_");
	if (r_split[0] == 'OK') {
		$('#comment_submit').attr('disabled', 'disabled');
		alert(r_split[1]);
		nv_commment_show();
	} else if (r_split[0] == 'ERR') {
		alert(r_split[1]);
	}
	return false;
}
function nv_commment_show() {
	$id = $('#articlesid').val();
	$('#showcomment').load(nv_siteroot + 'index.php?' + nv_lang_variable + '=' + nv_sitelang + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=listcomment&id='+$id);
}
function nv_commment_nextpage() {
	//alert('d');
	//$id = $('#articlesid').val();
	//$('#showcomment').load(nv_siteroot + 'index.php?' + nv_lang_variable + '=' + nv_sitelang + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=listcomment&id='+$id);
}