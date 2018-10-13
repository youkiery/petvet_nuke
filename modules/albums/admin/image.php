<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$month_dir_module = nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_name, date( "Y_m" ), true );

$table = "`" . NV_PREFIXLANG . "_" . $module_data . "_imgs`";
$aid = $nv_Request->get_int( 'aid', 'get', 0 );
$id = $nv_Request->get_int( 'id', 'get', 0 );
$data = array( 
    "id" => 0, "aid" => $aid, "title" => "", "alias" => "", "description" => "", "img" => "", "otherpath" => "", "status" => 0, "addtime" => NV_CURRENTTIME, "edittime" => NV_CURRENTTIME 
);
$data_albums = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = " . $aid . "";
$result = $db->sql_query( $sql );
$data_albums = $db->sql_fetchrow( $result, 2 );
if ( empty( $data_albums ) )
{
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=album" );
    die();
}
$page_title = $lang_module['imgof'] . ' : ' . $data_albums['title'];
if ( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    $data['aid'] = $nv_Request->get_int( 'aid', 'post', 0 );
    $data['title'] = filter_text_input( 'title', 'post', '', 0 );
    $alias = filter_text_input( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" );
    $data['img'] = $nv_Request->get_string( 'img', 'post', '' );
    $data['img'] = substr( $data['img'], $lu );
    $data['otherpath'] = $nv_Request->get_string( 'otherpath', 'post', '' );
    $data['description'] = $nv_Request->get_string( 'description', 'post', '' );
    $data['status'] = $nv_Request->get_int( 'status', 'post', 0 );
    if ( empty( $data['title'] ) ) $error = $lang_module['image_title_erorr'];
    else
    {
        if ( $id == 0 )
        {
            //insert data
            $query = "INSERT INTO " . $table . " (`id` ,`aid` ,`title` ,`alias` ,`description` ,`img` ,`otherpath` ,`status` ,`addtime` ,`edittime` )
	         		  VALUES (NULL , " . $db->dbescape( $data['aid'] ) . ", " . $db->dbescape( $data['title'] ) . " , 
	         		  " . $db->dbescape( $data['alias'] ) . ", " . $db->dbescape( $data['description'] ) . " , 
	         		  " . $db->dbescape( $data['img'] ) . ", " . $db->dbescape( $data['otherpath'] ) . ", 
	         		  " . $db->dbescape( $data['status'] ) . ", " . $db->dbescape( $data['addtime'] ) . ", 
	         		  " . $db->dbescape( $data['edittime'] ) . ")";
            $newid = intval( $db->sql_query_insert_id( $query ) );
            if ( $newid > 0 )
            {
                nv_fix_img_albums( $aid );
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_img'], $data['title'], $admin_info['userid'] );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=imglist&aid=" . $aid );
                die();
            }
            else
            {
                $error = $lang_module['errorsave'];
            }
            $db->sql_freeresult();
        }
        elseif ( $id > 0 )
        {
            $query = "UPDATE " . $table . " SET 
    				  `aid`=" . $db->dbescape( $data['aid'] ) . ", 
    				  `title`=" . $db->dbescape( $data['title'] ) . ", 
    				  `alias` =  " . $db->dbescape( $data['alias'] ) . ", 
    				  `description`=" . $db->dbescape( $data['description'] ) . ",
    				  `img`=" . $db->dbescape( $data['img'] ) . ", 
    				  `otherpath`=" . $db->dbescape( $data['otherpath'] ) . ", 
    				  `status` =" . $db->dbescape( $data['status'] ) . "
    				  WHERE id=" . intval( $id ) . "
    				  ";
            $db->sql_query( $query );
            nv_fix_img_albums( $aid );
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=imglist&aid=" . $aid );
            die();
        }
    }
}
if ( $id > 0 )
{
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_imgs` WHERE `id` = '" . $id . "'";
    $result = $db->sql_query( $sql );
    $data = $db->sql_fetchrow( $result, 2 );
}
if ( ! empty( $data['img'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data['img'] ) )
{
    $data['img'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data['img'];
}
$xtpl = new XTemplate( "image.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'module_name', $module_name );
$xtpl->assign( 'DATA', $data );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );

$xtpl->assign( 'albums_title', $data_albums['title'] );
$xtpl->assign( 'albums_id', $data_albums['id'] );
if ( ! empty( $error ) )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.error' );
}

if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}
$xtpl->assign( 'CURRENT', NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" ) );
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>