<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$data = $module_config[$module_name];
$page_title = $lang_module['config'];
//////////////////////////////////////////////////////////////
$error = "";
if ( $nv_Request->get_int( 'save', 'post', 0 ) == 1 )
{
	$data['home_view'] = $nv_Request->get_string( 'home_view', 'post', '' );
	$data['home_view_type'] = $nv_Request->get_string( 'home_view_type', 'post', '' );
	$data['order'] = $nv_Request->get_string( 'home_view_order', 'post', '' );
    $data['homewidth'] = $nv_Request->get_int( 'homewidth', 'post', 0 );
    $data['homeheight'] = $nv_Request->get_int( 'homeheight', 'post', 0 );
    $data['per_page'] = $nv_Request->get_int( 'per_page', 'post', 0 );
    $data['per_row'] = $nv_Request->get_int( 'per_row', 'post', 0 );
    $data['active_hometext'] = $nv_Request->get_int( 'active_hometext', 'post', 0 );
    $data['active_comment'] = $nv_Request->get_int( 'active_comment', 'post', 0 );
    $data['comment_auto'] = $nv_Request->get_int( 'comment_auto', 'post', 0 );
    if ( $error == '' )
    {
        foreach ( $data as $config_name => $config_value )
        {
            $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES('" . NV_LANG_DATA . "', " . $db->dbescape( $module_name ) . ", " . $db->dbescape( $config_name ) . ", " . $db->dbescape( $config_value ) . ")" );
        }        
        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['config'], "config", $admin_info['userid'] );
        nv_del_moduleCache( 'settings' );
        nv_del_moduleCache( $module_name );
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=config' );
        die();
    }
}

$xtpl = new XTemplate( "config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'DATA', $data );

$check_view = array( 
    "view_home_all" => "", "view_home_none" => "" , "view_home_one" => "" 
);
$check_view[$data['home_view']] = "selected=\"selected\"";
foreach ( $check_view as $type_view => $select )
{
    $xtpl->assign( 'type_view', $type_view );
    $xtpl->assign( 'view_selected', $select );
    $xtpl->assign( 'name_view', $lang_module[$type_view] );
    $xtpl->parse( 'main.home_view_loop' );
}
$cktype_view = array( 
    "view_home_list" => "", "view_home_gird" => "" 
);
$cktype_view[$data['home_view_type']] = "selected=\"selected\"";
foreach ( $cktype_view as $type_view => $select )
{
    $xtpl->assign( 'type_view', $type_view );
    $xtpl->assign( 'view_selected', $select );
    $xtpl->assign( 'name_view', $lang_module[$type_view] );
    $xtpl->parse( 'main.home_view_type_loop' );
}

$order_view = array( 
    "random" => "", "weight" => "" ,"dateup" => "" ,"atoz" => "" ,"ztoa" => ""
);
$order_view[$data['order']] = "selected=\"selected\"";
foreach ( $order_view as $type_view => $select )
{
    $xtpl->assign( 'type_view', $type_view );
    $xtpl->assign( 'view_selected', $select );
    $xtpl->assign( 'name_view', $lang_module[$type_view] );
    $xtpl->parse( 'main.home_view_order_loop' );
}
$check = ( $data['active_hometext'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'ck_active_hometext', $check );
$check = ( $data['active_comment'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'ck_active_comment', $check );
$check = ( $data['comment_auto'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'ck_comment_auto', $check );

if ( ! empty( $error ) )
{
    $xtpl->assign( 'error', $error );
    $xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['config'];

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>