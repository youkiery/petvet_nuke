/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

function nv_change_status (id)
{
	var href = nv_siteroot + 'admin/index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=action&ac=status&id=' + id;
	$.ajax({	
		type: 'POST',
		url: href,
		data:'',
		success: function(data){				
		}
	});
}
function nv_change_weight (id,obj)
{
	var w = $(obj).val();
	var href = nv_siteroot + 'admin/index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=action&ac=weight&id=' + id+'&w='+w;
	$.ajax({	
		type: 'POST',
		url: href,
		data:'',
		success: function(data){				
			window.location = nv_siteroot + "admin/index.php?" + nv_lang_variable + '=' + nv_sitelang  + '&' + nv_name_variable + '=' + nv_module_name;
		}
	});
}
function nv_module_del(id)
{
	if (confirm(lang_confirm))
	{
		var href = nv_siteroot + 'admin/index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=action&ac=del&id=' + id;
		$.ajax({	
			type: 'POST',
			url: href,
			data:'',
			success: function(data){				
				window.location = nv_siteroot + "admin/index.php?" + nv_lang_variable + '=' + nv_sitelang  + '&' + nv_name_variable + '=' + nv_module_name;
			}
		});
	}
}
function get_alias(mod,id) {
	var title = strip_tags(document.getElementById('idtitle').value);
	if (title != '') {
		nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=alias&title=' + encodeURIComponent(title), '', 'res_get_alias');
	}
	return false;
}
function res_get_alias(res) {
	if (res != "") {
		document.getElementById('idalias').value = res;
	} else {
		document.getElementById('idalias').value = '';
	}
	return false;
}
function nv_chang_block_cat(bid, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + bid, 5000);
	var new_vid = document.getElementById('id_' + mod + '_' + bid).options[document.getElementById('id_' + mod + '_' + bid).selectedIndex].value;
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=chang_block_cat&bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid + '&num=' + nv_randomPassword(8), '', 'nv_chang_block_cat_result');
	return;
}

// ---------------------------------------

function nv_chang_block_cat_result(res) {
	var r_split = res.split("_");
	if (r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	clearTimeout(nv_timer);
	nv_show_list_block_cat();
	return;
}

// ---------------------------------------

function nv_show_list_block_cat() {
	if (document.getElementById('module_show_list')) {
		nv_ajax("get", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block_cat&num=' + nv_randomPassword(8), 'module_show_list');
	}
	return;
}

// ---------------------------------------

function nv_chang_block(bid, id, mod) {
	var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
	var new_vid = document.getElementById('id_weight_' + id).options[document.getElementById('id_weight_' + id).selectedIndex].value;
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&id=' + id + '&bid=' + bid + '&&mod=' + mod + '&new_vid=' + new_vid + '&num=' + nv_randomPassword(8), '', 'nv_chang_block_result');
	return;
}

// ---------------------------------------

function nv_chang_block_result(res) {
	var r_split = res.split("_");
	if (r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	var bid = parseInt(r_split[1]);
	nv_show_list_block(bid);
	return;
}

// ---------------------------------------

function nv_show_list_block(bid) {
	if (document.getElementById('module_show_list')) {
		nv_ajax("get", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block&bid=' + bid + '&num=' + nv_randomPassword(8), 'module_show_list');
	}
	return;
}

// ---------------------------------------

function nv_del_block_list(oForm, bid) {
	var del_list = '';
	var fa = oForm['idcheck[]'];
	if (fa.length) {
		for ( var i = 0; i < fa.length; i++) {
			if (fa[i].checked) {
				del_list = del_list + ',' + fa[i].value;
			}
		}
	} else {
		if (fa.checked) {
			del_list = del_list + ',' + fa.value;
		}
	}

	if (del_list != '') {
		nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&del_list=' + del_list + '&bid=' + bid + '&num=' + nv_randomPassword(8), '', 'nv_chang_block_result');
	}
}