<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'LINK_ADD', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content" );
$page = $nv_Request->get_int( 'page', 'get', 0 );
$per_page = 30;

$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` ORDER BY weight ASC LIMIT " . $page . "," . $per_page."";
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;

if ( $all_page > 0 )
{
    while ( $row = $db->sql_fetchrow($result) )
    {
    	$row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $row['id'];
    	$row['weight'] = drawselect_number("weight",1,$all_page+1,$row['weight'],'nv_change_weight ('.$row['id'].',this)');
    	$row['status'] =drawselect_yesno ( "status", $row['status'] , 'nv_change_status('.$row['id'].')');
    	$xtpl->assign( 'ROW', $row );
    	$xtpl->parse( 'main.loop' );
    }
}
else
{
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content" );
    die();
}
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if (!empty($generate_page))
{
	$xtpl->assign( 'PAGES', $generate_page );
}
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['main'];

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>