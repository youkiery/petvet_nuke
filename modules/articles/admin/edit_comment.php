<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */
 
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['comment_edit_title'];
$cid = $nv_Request->get_int( 'cid', 'get' );
$status = 0;
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
    nv_insert_logs( NV_LANG_DATA, $module_name, 'log_edit_comment', "id " . $cid, $admin_info['userid'] );
    if ( $cid > 0 )
    {
    	$sql = "SELECT id FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE cid='" . $cid . "'";
        $result = $db->sql_query( $sql );
        list($id) = $db->sql_fetchrow($result);
        $delete = $nv_Request->get_int( 'delete', 'post', 0 );
        if ( $delete )
        {
            $db->sql_query( "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE `cid`=" . $cid );
        }
        else
        {
            $content = nv_nl2br( filter_text_textarea( 'content', '', NV_ALLOWED_HTML_TAGS ) );
            $active = $nv_Request->get_int( 'active', 'post', 0 );
            $status = ( $status == 1 ) ? 1 : 0;
            $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_comment` SET `content`=" . $db->dbescape( $content ) . ", `status`=" . $active . " WHERE `cid`=" . $cid );
        }
        // Cap nhat lai so luong comment duoc kich hoat
        list( $numf ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` where `id`= '" . $id . "' AND `status`=1" ) );
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `comment`=" . $numf . " WHERE `id`=" . $id;
        $db->sql_query( $query );    
    }
    header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=comment' );
    die();
}

$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE cid=" . $cid . "";
$result = $db->sql_query( $sql );

if ( $db->sql_numrows( $result ) == 0 )
{
    header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=comment' );
    die();
}

$row = $db->sql_fetchrow( $result );
$row['content'] = nv_htmlspecialchars( nv_br2nl( $row['content'] ) );

$row['status'] = ( $row['status'] ) ? "checked=\"checked\"" : "";

$xtpl = new XTemplate( "comment_edit.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$xtpl->assign( 'CID', $cid );
$xtpl->assign( 'ROW', $row );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>