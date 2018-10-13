<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */
 
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['comment'];

$page = $nv_Request->get_int( 'page', 'get', 0 );
$per_page = 30;
$sql = "SELECT SQL_CALC_FOUND_ROWS a.cid, a.post_name, a.content, a.post_email, a.status, b.id, b.title, b.alias FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` a INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "` b ON (a.id=b.id) LIMIT " . $page . "," . $per_page . "";
$result = $db->sql_query( $sql );

$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $all_page ) = $db->sql_fetchrow( $result_all );
$all_page = ( $all_page ) ? $all_page : 1;

$array = array();
$a = 0;
while ( list( $cid, $post_name,$content, $email, $status, $id, $title, $alias ) = $db->sql_fetchrow( $result ) )
{
    $a ++;
	$array[$cid] = array (
		"class" => ( $a % 2 ) ? " class=\"second\"" : "",
		"cid" => $cid,
		"name" => $post_name,
		"email" => $email,
		"content" => $content,
		"link" => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $alias . "-" . $id,
		"title" => $title,
		"status" => ( $status == 1 ) ? $lang_module['comment_enable'] : $lang_module['comment_disable'],
		"linkedit" => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=edit_comment&cid=" . $cid,
		"linkdelete" => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=del_comment&list=" . $cid
	);
}

$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );

$xtpl = new XTemplate( "comment.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

foreach ( $array as $row )
{
	$xtpl->assign( 'ROW', $row );
	$xtpl->parse( 'main.loop' );	
}

if ( ! empty ( $generate_page ) )
{
	$xtpl->assign( 'GENERATE_PAGE', $generate_page );
	$xtpl->parse( 'main.generate_page' );	
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>