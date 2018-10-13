<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$table = "`" . NV_PREFIXLANG . "_" . $module_data . "_imgs`";

/*action del row*/
$ac = $nv_Request->get_string( 'ac', 'get', '' );
if ( $ac == 'del' )
{
    $id = $nv_Request->get_int( 'id', 'get', 0 );
    if ( $id > 0 )
    {
        $sql = "SELECT * FROM ".$table." WHERE `id` = '" . $id . "'";
        $result = $db->sql_query( $sql );
        $data = $db->sql_fetchrow( $result, 2 );
    }
    $sql = "DELETE FROM " . $table . " WHERE `id` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
    nv_fix_img_albums( $data['aid'] );
    die( $lang_module['del_complate'] );
}
if ( $ac == 'active' )
{
    $id = $nv_Request->get_int( 'id', 'post', 0 );
    $value = $nv_Request->get_int( 'value', 'post', 0 );
    $sql = "UPDATE " . $table . " SET status = " . $value . " WHERE `id` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
    if ( $id > 0 )
    {
        $sql = "SELECT * FROM ".$table." WHERE `id` = '" . $id . "'";
        $result = $db->sql_query( $sql );
        $data = $db->sql_fetchrow( $result, 2 );
    }
    nv_fix_img_albums( $data['aid'] );
    die( $lang_module['del_complate'] );
}
$page_title = $lang_module['imglist'];
$aid = $nv_Request->get_int( 'aid', 'get', 0 );
$per_page = 30;
$page = $nv_Request->get_int( 'page', 'get', 0 );

$array_inhome = array( 
    0 => $lang_global['no'], 1 => $lang_global['yes'] 
);

$xtpl = new XTemplate( "imglist.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'URLBACK', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=imglist&aid=".$aid );
$xtpl->assign( 'ADDCONTENT', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=image&aid=".$aid );
$where = "";
if ( $aid > 0 ) 
{
    $where = " WHERE aid=" . $aid; 
	$sql = "SELECT * FROM " . "`" . NV_PREFIXLANG . "_" . $module_data . "_rows`" . " WHERE `id` = '" . $aid . "'";
    $result = $db->sql_query( $sql );
    $data_temp = $db->sql_fetchrow( $result, 2 );
    if (!empty($data_temp)) $page_title = $lang_module['imglistof']." : " . $data_temp['title'];
}
//begin: listdata
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " " . $where . " ORDER BY addtime DESC LIMIT " . $page . "," . $per_page ;
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$i = $page+1;
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $row['bg'] = ( $i % 2 == 0 ) ? "class=\"second\"" : "";
    $row['no'] = $i;
    $row['time'] = date( "d.m.Y", $row['addtime'] );
    if ( ! empty( $row['img'] ) )
    {
        $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
        $row['imgsrc'] = $imageinfo['src'];
    }
    $row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&ac=del&id=" . $row['id'];
    $row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=image&aid=".$aid."&id=" . $row['id'];
    $row['sinhome'] = drawselect_status( "status", $array_inhome, $row['status'], "ChangeActiveImg(this," . $row['id'] . ",'active','" . $row['aid'] . "')" );
    $xtpl->assign( 'ROW', $row );
    if ( ! empty( $row['imgsrc'] ) ) $xtpl->parse( 'main.loop.img' );
    $xtpl->parse( 'main.loop' );
    $i ++;
}
//end: listdata
$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;
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