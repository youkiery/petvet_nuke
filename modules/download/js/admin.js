function nv_chang_weight(a){nv_settimeout_disable("weight"+a,5E3);var c=document.getElementById("weight"+a).options[document.getElementById("weight"+a).selectedIndex].value;nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=cat&changeweight=1&catid="+a+"&new="+c+"&num="+nv_randomPassword(8),"","nv_chang_weight_result")}function nv_chang_weight_result(a){a!="OK"&&alert(nv_is_change_act_confirm[2]);clearTimeout(nv_timer);window.location.href=window.location.href}
function nv_chang_status(a){nv_settimeout_disable("change_status"+a,5E3);nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=cat&changestatus=1&catid="+a+"&num="+nv_randomPassword(8),"","nv_chang_status_res")}function nv_chang_status_res(a){if(a!="OK")alert(nv_is_change_act_confirm[2]),window.location.href=window.location.href}
function nv_row_del(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=cat&del=1&catid="+a,"","nv_row_del_result");return!1}function nv_row_del_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}function nv_file_del(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&del=1&id="+a,"","nv_file_del_result");return!1}
function nv_file_del_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}function nv_chang_file_status(a){nv_settimeout_disable("change_status"+a,5E3);nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&changestatus=1&id="+a+"&num="+nv_randomPassword(8),"","nv_chang_file_status_res")}function nv_chang_file_status_res(a){if(a!="OK")alert(nv_is_change_act_confirm[2]),window.location.href=window.location.href}
function nv_filequeue_del(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=filequeue&del=1&id="+a,"","nv_filequeue_del_result");return!1}function nv_filequeue_del_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}
function nv_filequeue_alldel(){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=filequeue&alldel=1","","nv_filequeue_alldel_result");return!1}function nv_filequeue_alldel_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}
function nv_checkfile(a,c,b){nv_settimeout_disable(b,5E3);b=document.getElementById(a).value;if(trim(b)=="")return document.getElementById(a).value="",!1;b=rawurlencode(b);nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&check=1&url="+b+"&is_myurl="+c+"&num="+nv_randomPassword(8),"","nv_checkfile_result");return!1}
function nv_gourl(a,c,b){nv_settimeout_disable(b,5E3);b=document.getElementById(a).value;if(trim(b)=="")return document.getElementById(a).value="",!1;c?(b=rawurlencode(b),window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&fdownload="+b):b.match(/^(http|ftp)\:\/\/\w+([\.\-]\w+)*\.\w{2,4}(\:\d+)*([\/\.\-\?\&\%\#]\w+)*\/?$/i)?window.open(b).focus():(alert(nv_url),document.getElementById(a).focus());return!1}function nv_checkfile_result(a){alert(a);return!1}
function nv_report_del(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=report&del=1&id="+a,"","nv_report_del_result");return!1}function nv_report_del_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}
function nv_report_check(a){nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=report&linkcheck=1&id="+a+"&num="+nv_randomPassword(8),"","nv_report_check_result");return!1}
function nv_report_check_result(a){a=a.split("_");if(a[0]=="OK"){var c=document.getElementById("report_check_ok").value;confirm(c)&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=report&del=1&id="+a[1],"","nv_report_del_result")}else a[0]=="NO"?(c=document.getElementById("report_check_error").value,confirm(c)&&nv_report_edit(a[1])):(c=document.getElementById("report_check_error2").value,confirm(c)&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+
"&"+nv_fc_variable+"=report&del=1&id="+a[1],"","nv_report_del_result"));return!1}function nv_report_edit(a){window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&edit=1&id="+a+"&report=1";return!1}function nv_report_alldel(){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=report&alldel=1","","nv_report_alldel_result");return!1}
function nv_report_alldel_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}function nv_chang_comment_status(a){nv_settimeout_disable("status"+a,5E3);nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=comment&changestatus=1&id="+a+"&num="+nv_randomPassword(8),"","nv_chang_comment_status_res")}function nv_chang_comment_status_res(a){a!="OK"&&alert(nv_is_change_act_confirm[2]);window.location.href=window.location.href}
function nv_comment_del(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=comment&del=1&id="+a,"","nv_comment_del_result");return!1}function nv_comment_del_result(a){a=="OK"?window.location.href=window.location.href:alert(nv_is_del_confirm[2]);return!1}
function nv_file_additem(){file_items++;var a='<input readonly="readonly" class="txt" value="" name="fileupload[]" id="fileupload'+file_items+'" style="width : 300px" maxlength="255" />';a+='&nbsp;<input type="button" value="'+file_selectfile+'" name="selectfile" onclick="nv_open_browse_file( \''+nv_base_adminurl+"index.php?"+nv_name_variable+"=upload&popup=1&area=fileupload"+file_items+"&path="+file_dir+"&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" />";
a+='&nbsp;<input type="button" value="'+file_checkUrl+'" id= "check_fileupload'+file_items+'" onclick="nv_checkfile( \'fileupload'+file_items+"', 1, 'check_fileupload"+file_items+"' ); \" />";a+='&nbsp;<input type="button" value="'+file_gourl+'" id= "go_fileupload'+file_items+'" onclick="nv_gourl( \'fileupload'+file_items+"', 1, 'go_fileupload"+file_items+"' ); \" /><br />";$("#fileupload_items").append(a)}
function nv_file_additem2(){var a='<input readonly="readonly" class="txt" value="" name="fileupload2[]" id="fileupload2_'+file_items+'" style="width : 300px" maxlength="255" />';a+='&nbsp;<input type="button" value="'+file_selectfile+'" name="selectfile" onclick="nv_open_browse_file( \''+nv_base_adminurl+"index.php?"+nv_name_variable+"=upload&popup=1&area=fileupload2_"+file_items+"&path="+file_dir+"&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" />";
a+='&nbsp;<input type="button" value="'+file_checkUrl+'" id= "check_fileupload2_'+file_items+'" onclick="nv_checkfile( \'fileupload2_'+file_items+"', 1, 'check_fileupload2_"+file_items+"' ); \" />";a+='&nbsp;<input type="button" value="'+file_gourl+'" id= "go_fileupload2_'+file_items+'" onclick="nv_gourl( \'fileupload2_'+file_items+"', 1, 'go_fileupload2_"+file_items+"' ); \" /><br />";$("#fileupload2_items").append(a);file_items++}
function nv_linkdirect_additem(){var a='<textarea name="linkdirect[]" id="linkdirect'+linkdirect_items+'" style="width : 300px; height : 150px"></textarea>';a+='&nbsp;<input type="button" value="'+file_checkUrl+'" id="check_linkdirect'+linkdirect_items+'" onclick="nv_checkfile( \'linkdirect'+linkdirect_items+"', 0, 'check_linkdirect"+linkdirect_items+"' ); \" /><br />";$("#linkdirect_items").append(a);linkdirect_items++};
