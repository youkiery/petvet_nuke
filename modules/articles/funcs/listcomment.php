<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_MOD_ARTICLES' ) ) die( 'Stop!!!' );

$contents = "";
$table_name = NV_PREFIXLANG . "_" . $module_data . "_comment";
$page = $nv_Request->get_int( 'page', 'get', 0 );
$id = $nv_Request->get_int( 'id', 'get', 0 );
$per_page = 20;
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE status =1 AND id=".intval($id)." ORDER BY cid DESC LIMIT " . $page . "," . $per_page . "";
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name.'&amp;'.NV_OP_VARIABLE.'='.$op.'&amp;id='.$id;

if ($numf>0)
{
	$xtpl = new XTemplate( "listcomment.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	while ( $row = $db->sql_fetchrow( $result ) )
	{
		$row['post_time'] = nv_date( "l - d/m/Y  H:i A", $row['post_time'] );
	    $xtpl->assign( 'ROW', $row );
	    $xtpl->parse( 'main.loop' );
	}
	$pages_html = nv_generate_page_articles ($base_url, $all_page, $per_page, $page,true, true, 'nv_urldecode_ajax','showcomment' );
	if (!empty($pages_html))
	{
		$xtpl->assign( 'pages_html', $pages_html );
		$xtpl->parse( 'main.page' );
	}
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
}
include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );
?>