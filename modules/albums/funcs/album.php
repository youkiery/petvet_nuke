<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_ALBUMS' ) )
{
    die( 'Stop!!!' );
}

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
$aid = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $aid = intval( end( $temp ) );
    }
}
$page = 0;
if ( ! empty( $array_op[2] ) )
{
    $temp = explode( '-', $array_op[2] );
    if ( ! empty( $temp ) )
    {
        $page = intval( end( $temp ) );
    }
}
$base_url = "" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;
//update view
$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET view=view+1 WHERE id=" . $aid . "";
$result = $db->sql_query( $sql );

if ( $data_config['view_album'] == "view_listclick" )
{
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . "`" . NV_PREFIXLANG . "_" . $module_data . "_imgs`" . " WHERE status=1 AND aid=" . $aid . " ORDER BY addtime DESC LIMIT " . $page . "," . $per_page;
    $result = $db->sql_query( $sql );
    $result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
    list( $numf ) = $db->sql_fetchrow( $result_all );
    $all_page = ( $numf ) ? $numf : 1;
    $data_content = array();
    $i = $page + 1;
    while ( $row = $db->sql_fetchrow( $result, 2 ) )
    {
        $row['no'] = $i;
        $data_content[] = $row;
        $i ++;
    }
    $html_pages = nv_albums_page( $base_url, $all_page, $per_page, $page );
    $contents = view_alistimg( $data_content, $html_pages );
}
elseif ( $data_config['view_album'] == "view_slideimg" )
{
    $sql = "SELECT * FROM " . "`" . NV_PREFIXLANG . "_" . $module_data . "_imgs`" . " WHERE status=1 AND aid=" . $aid . " ORDER BY addtime DESC";
    $result = $db->sql_query( $sql );
    $data_content = array();
    $i = 1;
    while ( $row = $db->sql_fetchrow( $result, 2 ) )
    {
        $row['no'] = $i;
        $data_content[] = $row;
        $i ++;
    }
    $contents = view_slideimg( $data_content );
}
else
    $contents = "";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>