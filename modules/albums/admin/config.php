<?php
/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['config'];
$data = $module_config[$module_name];
$groups_list = nv_groups_list();
$savesetting = $nv_Request->get_int( 'savesetting', 'post', 0 );
$error = "";
if ( $savesetting == 1 )
{
    $data['view_type'] = $nv_Request->get_string( 'view_type', 'post', '' );
    $data['view_album'] = $nv_Request->get_string( 'view_album', 'post', '' );
    $data['view_num'] = $nv_Request->get_int( 'view_num', 'post', 0 );
    foreach ( $data as $config_name => $config_value )
    {
        $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES('" . NV_LANG_DATA . "', " . $db->dbescape( $module_name ) . ", " . $db->dbescape( $config_name ) . ", " . $db->dbescape( $config_value ) . ")" );
    }
    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['config_title'], "setting", $admin_info['userid'] );
    nv_del_moduleCache( 'settings' );
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=config' );
    die();
}

$xtpl = new XTemplate( "config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'DATA', $data );

$home_view = array( 
    "view_listimg" => "", "view_album" => "","view_none" => "" 
);
$view_album = array( 
    "view_listclick" => "", "view_slideimg" => ""
);
$home_view[$data['view_type']] = "selected=\"selected\"";
foreach ( $home_view as $type_view => $select )
{
	$row = array( "title"=>$lang_module[$type_view],"select"=>$select,"value"=> $type_view);
    $xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.home_view_loop' );
}
$view_album[$data['view_album']] = "selected=\"selected\"";
foreach ( $view_album as $type_view => $select )
{
	$row = array( "title"=>$lang_module[$type_view],"select"=>$select,"value"=> $type_view);
    $xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.album_view_loop' );
}
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>