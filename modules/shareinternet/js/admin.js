/**
** @Project: NUKEVIET SUPPORT ONLINE
** @Author: Viet Group (vietgroup.biz@gmail.com)
** @Copyright: VIET GROUP
** @Craetdate: 19.08.2011
** @Website: http://vietgroup.biz
*/

//  ---------------------------------------
function nv_chang_weight( vid )
{
   var nv_timer = nv_settimeout_disable( 'change_weight_' + vid, 5000 );
   var new_weight = document.getElementById( 'change_weight_' + vid ).options[document.getElementById( 'change_weight_' + vid ).selectedIndex].value;
   nv_ajax( "post", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=change_weight&id=' + vid + '&new_weight=' + new_weight + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_weight_res' );
   return;
}

//  ---------------------------------------

function nv_chang_weight_res( res )
{
   var r_split = res.split( "_" );
   if( r_split[0] != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
   }
   clearTimeout( nv_timer );
   nv_show_list_mods();
   return;
}

function nv_show_list_mods()
{
   if( document.getElementById( 'module_show_list' ) )
   {
      nv_ajax( "get", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=list&num=' + nv_randomPassword( 8 ), 'module_show_list' );
   }
   return;
}

function nv_module_del(did)
{
   if (confirm(nv_is_del_confirm[0]))
   {
      nv_ajax( 'post', script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=del&id=' + did, '', 'nv_module_del_result' );
   }
   return false;
}

function nv_module_del_result(res)
{
   var r_split = res.split( "_" );
   if(r_split[0] == 'OK')
   {
      window.location.href = strHref;
   }
   else
   {
      alert(nv_is_del_confirm[2]);
   }
   return false;
}

//---------------------------------------
function nv_module_del_group(did)
{
   if (confirm(nv_is_del_confirm[0]))
   {
      nv_ajax( 'post', script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=del_group&id=' + did, '', 'nv_module_del_group_result' );
   }
   return false;
}

function nv_module_del_group_result(res)
{
   var r_split = res.split( "_" );
   if(r_split[0] == 'OK')
   {
      window.location.href = strHref;
   }
   else
   {
      alert(nv_is_del_confirm[2]);
   }
   return false;
}
function nv_chang_weightg( vid )
{
   var nv_timer = nv_settimeout_disable( 'change_weightg_' + vid, 5000 );
   var new_weight = document.getElementById( 'change_weightg_' + vid ).options[document.getElementById( 'change_weightg_' + vid ).selectedIndex].value;
   nv_ajax( "post", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=change_weightg&id=' + vid + '&new_weight=' + new_weight + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_weightg_res' );
   return;
}

//  ---------------------------------------

function nv_chang_weightg_res( res )
{
   var r_split = res.split( "_" );
   if( r_split[0] != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
   }
   clearTimeout( nv_timer );
   nv_show_listg_mods();
   return;
}

function nv_show_listg_mods()
{
   if( document.getElementById( 'module_show_list_group' ) )
   {
      nv_ajax( "get", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=list_group&num=' + nv_randomPassword( 8 ), 'module_show_list_group' );
   }
   return;
}