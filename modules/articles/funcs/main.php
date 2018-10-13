<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_MOD_ARTICLES' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$array_data = array();
$page = $nv_Request->get_int( 'page', 'get', 0 );
$per_page = $articles_config['per_page'];
$contents = "";
$order = $where = $contents = "";
switch ( $articles_config['order'] )
{
	case "random" : $order = "ORDER BY RAND()" ; break;
	case "weight" : $order = "ORDER BY weight ASC" ; break;
	case "dateup" : $order = "ORDER BY ID DESC" ; break;
	case "atoz" : $order = "ORDER BY title ASC" ; break;
	case "ztoa" : $order = "ORDER BY title DESC" ; break;
}
if (!empty ($where))
{
	$where .= " AND ".$where;
}
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE status =1 AND inhome=1 ".$where." ".$order." LIMIT " . $page . "," . $per_page . "";
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name.'&amp;'.NV_OP_VARIABLE.'='.$op;

while ( $row = $db->sql_fetchrow( $result ) )
{
    $array_data[]= $row;
}
$pages_html = nv_generate_page_articles ($base_url, $all_page, $per_page, $page );

$contents = call_user_func( $articles_config['home_view'], $array_data ,$pages_html);

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>