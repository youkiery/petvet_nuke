<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$table = "`" . NV_PREFIXLANG . "_" . $module_data . "_rows`";

/*action del row*/
$ac = $nv_Request->get_string( 'ac', 'get', '' );
if ( $ac == 'del' )
{
    $id = $nv_Request->get_int( 'id', 'get', 0 );
    $sql = "DELETE FROM " . $table . " WHERE `id` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
    $sql = "DELETE FROM " . "`" . NV_PREFIXLANG . "_" . $module_data . "_imgs`" . " WHERE `aid` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_albums'], $id, $admin_info['userid'] );
    die( $lang_module['del_complate'] );
}
if ( $ac == 'active' )
{
    $id = $nv_Request->get_int( 'id', 'post', 0 );
    $value = $nv_Request->get_int( 'value', 'post', 0 );
    $sql = "UPDATE " . $table . " SET inhome = " . $value . " WHERE `id` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_name, 'edit_albums', $id, $admin_info['userid'] );
    die( $lang_module['del_complate'] );
}
$page_title = $lang_module['main'];
$per_page = 30;
$page = $nv_Request->get_int( 'page', 'get', 0 );
$q = filter_text_input( 'q', 'get', '', 1 );

$array_inhome = array( 
    0 => $lang_global['no'], 1 => $lang_global['yes'] 
);

$xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'q', $q );
$xtpl->assign( 'URLBACK', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&q=" . $q . "&page=" . $page );
$xtpl->assign( 'ADDCONTENT', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=album" );

//begin: listdata
$where = array();
$where_sql = "";
if ( ! empty( $q ) ) $where[] = " ( title LIKE '%" . $db->dblikeescape( $q ) . "%' OR hometext LIKE '%" . $db->dblikeescape( $q ) . "%' ) ";
if ( ! empty( $where ) )
{
    $where_sql = " WHERE " . implode( " AND ", $where );
}
$sql = "SELECT SQL_CALC_FOUND_ROWS t1.*, t2.full_name FROM " . $table . " as t1 LEFT JOIN ".NV_USERS_GLOBALTABLE." as t2 ON t1.admins=t2.userid " . $where_sql . " ORDER BY add_time DESC LIMIT " . $page . "," . $per_page;
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$i = $page + 1;
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $row['bg'] = ( $i % 2 == 0 ) ? "class=\"second\"" : "";
    $row['no'] = $i;
    $row['time'] = date("d.m.Y",$row['edit_time']);
    if ( ! empty( $row['img'] ) )
    {
        $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
        $row['imgsrc'] = $imageinfo['src'];
    }
    $row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&ac=del&id=" . $row['id'];
    $row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=album&id=" . $row['id'];
    $row['link'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=imglist&aid=".$row['id'];
    $row['add'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=image&aid=" . $row['id'];
    $row['sinhome'] = drawselect_status( "inhome", $array_inhome, $row['inhome'], "ChangeActiveAlbums(this," . $row['id'] . ",'active')" );
    $xtpl->assign( 'ROW', $row );
    if( !empty($row['imgsrc'])) $xtpl->parse( 'main.loop.img' );
    $xtpl->parse( 'main.loop' );
    $i ++;
}
//end: listdata
$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&q=" . $q;
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if ( $generate_page != "" )
{
    $xtpl->assign( 'generate_page', $generate_page );
    $xtpl->parse( 'main.page' );
}
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>