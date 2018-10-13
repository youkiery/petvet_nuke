/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

// function checkall end uncheckall
function clickcheckall(){
	$('#checkall').click(function(){
		if ( $(this).attr('checked') ){
			$('input:checkbox').each(function(){
				$(this).attr('checked','checked');
			});
		}else {
			$('input:checkbox').each(function(){
			$(this).removeAttr('checked');
			});
		}
	});
}

//change active
function ChangeActiveAlbums(idobject,id,action){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&ac='+action,
		data:'id='+id + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main';
			}
		}
	});
}
function ChangeActiveImg(idobject,id,action,aid){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=imglist&ac='+action,
		data:'id='+id + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=imglist&aid='+aid;
			}
		}
	});
}
function get_alias() {
	var title = strip_tags(document.getElementById('idtitle').value);
	if (title != '') {
		$.ajax({	
			type: 'POST',
			url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=alias&title=' + encodeURIComponent(title),
			data:'',
			success: function(data){
				if (data != "") {
					document.getElementById('idalias').value = data;
				} else {
					document.getElementById('idalias').value = '';
				}
			}
		});
	}
	return false;
}
function show_group() {
	var igroup = $('#id_who_view').val();
	if ( igroup == 3 )
	{
		$('#id_groups_view').show();
	}
	else
	{
		$('#id_groups_view').hide();
	}
}
function search_rows()
{
	var catid = $('#catid').val();
	var q = $('#idq').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&catid='+catid+'&q='+encodeURIComponent(q);
}
function delete_one(class_name,lang_confirm,url_back){
	$('a.'+class_name).click(function(event){
		event.preventDefault();
		if (confirm(lang_confirm))
		{
			var href= $(this).attr('href');
			$.ajax({	
				type: 'POST',
				url: href,
				data:'',
				success: function(data){				
					alert(data);
					if (url_back !='') {
						window.location=url_back;
					}
				}
			});
		}
	});
}

// delete all items select checkbox
function delete_all(filelist,class_name,lang_confirm,lang_error,url_del,url_back){
	$('a.'+class_name).click(function(event){
		event.preventDefault();
		var listall = [];
		$('input.'+filelist+':checked').each(function(){
			listall.push($(this).val());
		});
		if (listall.length<1){
			alert(lang_error);
			return false;
		}
		if (confirm(lang_confirm))
		{
			$.ajax({	
				type: 'POST',
				url: url_del,
				data:'listall='+listall,
				success: function(data){	
					window.location=url_back;
				}
			});
		}
	});
}
function content_submit(status)
{
	$('#idstatus').val(status);
	$('#idcontent').submit();
}
//////